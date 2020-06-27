document.addEventListener("DOMContentLoaded", function (event) {

    let codigoBarraShoot = document.getElementById('codigoBarraShoot');


    let createTD = (value) => {
        let td = document.createElement('td');
        td.innerText = value;
        return td;
    }

    let indice = 0;
    let cantidad = 1;

    let llenarTabla = (producto) => {

        let table = document.getElementById('table');
        let tr = document.createElement('tr');

        tr.appendChild(createTD(indice+=1))
        tr.appendChild(createTD(producto.nombre))
        tr.appendChild(createTD(producto.precio))
        tr.appendChild(createTD(producto.codigodebarra))
        tr.appendChild(createTD(producto.categoria))
        tr.appendChild(createTD(cantidad))

        table.appendChild(tr);

    }

    let searchProduct = function (idProducto) {
        let methodHTTP = 'POST';
        let url = 'codigodebarra';
        let parametros = 'id=' + idProducto;

        var xhttp = new XMLHttpRequest();
        xhttp.open(methodHTTP, url, true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                let producto = JSON.parse(xhttp.responseText)

                if (producto == false) {
                    $('#agregarModal').modal();
                } else {
                    
                    llenarTabla(producto);
                }
            }
        };
        xhttp.send(parametros);
    }

    let eventCodigoBarraShooted = function () {
        let codigoBarraShooted = document.getElementById('codigoBarraShooted');
        let id = codigoBarraShooted.value;
        searchProduct(id)
    }
    codigoBarraShoot.addEventListener('click', eventCodigoBarraShooted)

});