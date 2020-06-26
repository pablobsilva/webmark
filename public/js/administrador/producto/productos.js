document.addEventListener("DOMContentLoaded", function(event) {

    let editProducts = document.getElementsByClassName('editProduct');

    editProducto.addEventListener('click', obtenerProductoInput)

});

function setEventOnEditProduct(editProducts) {
    for (let i = 0; i < editProducts.length; i++) {
        editProducts[i].addEventListener('click', obtenerProductoInput, false);
    }
}


function obtenerProductoInput() {

    let idProducto = this.getAttribute("data-product-id");

    obtenerProducto(idProducto, rellenarModal)

}

function obtenerProducto(idProducto, functionExecute) {

    let methodHTTP = 'POST';
    let url = '';
    let parametros = idProducto;

    var xhttp = new XMLHttpRequest();
    xhttp.open( methodHTTP, url, true );
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            functionExecute(xhttp.responseText);
        }
    };

    xhttp.send(parametros);

}

function rellenarModal(producto) {

    let nombre = document.getElementById('nombreModificar');
    let precio = document.getElementById('precioModificar');
    let codigoBarra = document.getElementById('codigoBarraModificar');
    let categoria = document.getElementById('categoriaModificar');
    let empresa = document.getElementById('empresaModificar');
    let cantidad = document.getElementById('cantidadModificar');

    nombre.value = producto.nombre;
    precio.value = producto.precio;
    codigoBarra.value = producto.codigoBarra;
    categoria.value = producto.categoria;
    empresa.value = producto.empresa;
    cantidad.value = producto.cantidad;

    $('#modificarModal').modal();

}