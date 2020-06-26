document.addEventListener("DOMContentLoaded", function (event) {

    let codigoBarraShoot = document.getElementById('codigoBarraShoot');

    producto = {}
    producto.nombre = 'za';
    producto.precio = 12;
    producto.codigoBarra = '121';
    producto.categoria = '12';
    producto.empresa = 'asdasd';
    producto.cantidad = 12;

    let createTD = (value) => {
        let td = document.createElement('td');
        td.innerText = value;
        return td;
    }

    let llenarTabla = (producto) => {

        let table = document.getElementById('table');
        let tr = document.createElement('tr');

        tr.appendChild(createTD(producto.nombre))
        tr.appendChild(createTD(producto.precio))
        tr.appendChild(createTD(producto.codigoBarra))
        tr.appendChild(createTD(producto.categoria))
        tr.appendChild(createTD(producto.cantidad))

        table.appendChild(tr);

    }

    let searchProduct = function (idProducto) {
        let methodHTTP = 'POST';
        let url = '';
        let parametros = 'id=' + idProducto;

        var xhttp = new XMLHttpRequest();
        xhttp.open(methodHTTP, url, true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                let producto = JSON.parse(xhttp.responseText)

                if (producto != {}) {
                    llenarTabla(producto);
                } else {
                    $('#agregarModal').modal();
                }

            }
        };

        xhttp.send(parametros);
    }

    let eventCodigoBarraShooted = function () {
        let codigoBarraShooted = document.getElementById('codigoBarraShooted');
        let id = codigoBarraShooted.innerText;
        searchProduct(id)
    }

    codigoBarraShoot.addEventListener('click', eventCodigoBarraShooted)

});