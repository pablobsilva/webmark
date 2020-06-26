document.addEventListener("DOMContentLoaded", function(event) {

    let editProducts = document.getElementsByClassName('editProduct');
    let deleteProducts = document.getElementsByClassName('deleteProduct');
    feather.replace()
    setEventOnEditProduct(editProducts);
    setEventOnDeleteProduct(deleteProducts);

});

function setEventOnEditProduct(editProducts) {
    for (let i = 0; i < editProducts.length; i++) {
        editProducts[i].addEventListener('click', obtenerProductoInput, false);
    }
}

function setEventOnDeleteProduct(deleteProducts) {
    for (let i = 0; i < deleteProducts.length; i++) {
        deleteProducts[i].addEventListener('click', eliminarProducto, false);
    }
}


function obtenerProductoInput() {

    let idProducto = this.getAttribute("data-product-id");

    obtenerProducto(idProducto, rellenarModal)

}

function obtenerProducto(idProducto, functionExecute) {

    let methodHTTP = 'POST';
    let url = 'productos/editar';
    let parametros =  "id=" + idProducto;

    var xhttp = new XMLHttpRequest();
    xhttp.open( methodHTTP, url, true );
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhttp.onreadystatechange = function() {
        if (producto != false) {
            llenarTabla(producto);
        } else {
            $('#agregarModal').modal();
        }
    };

    xhttp.send(parametros);
}

function eliminarProducto() {

    let idProducto = this.getAttribute("data-product-id");

    let methodHTTP = 'POST';
    let url = 'productos/eliminar';
    let parametros = 'id=' + idProducto;

    var xhttp = new XMLHttpRequest();
    xhttp.open( methodHTTP, url, true );
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

        }
    };
    xhttp.send(parametros);

}

function rellenarModal(producto) {

    let id = document.getElementById('idModificar');
    let nombre = document.getElementById('nombreModificar');
    let precio = document.getElementById('precioModificar');
    let codigoBarra = document.getElementById('codigoBarraModificar');
    let categoria = document.getElementById('categoriaModificar');
    let empresa = document.getElementById('empresaModificar');
    let cantidad = document.getElementById('cantidadModificar');

    producto = JSON.parse(producto);
    id.value = producto.idProducto;
    nombre.value = producto.nombre;
    precio.value = producto.precio;
    codigoBarra.value = producto.codigodebarra;
    empresa.value = producto.empresa;
    cantidad.value = producto.stock;

    for (i = 0; i < categoria.length; i++) {
        if(producto.categoria == categoria.options[i].value)
        {
            categoria.selectedIndex = categoria.options[i].index;
        }
    };
    $('#modificarModal').modal();
}

function deleteProduct()
{

}