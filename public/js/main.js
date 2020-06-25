document.querySelector("a[data-toggle=modal][href]").addEventListener('click', function () {
    var url = this.getAttribute("href");
    var target = this.getAttribute("data-target");
    axios.get(url).then(function (respuesta) {
        document.querySelector(target+' .modal-body').innerHTML = respuesta.data;
    });
});

/* Codigo para mandar las vistas a los modales según corresponda */




