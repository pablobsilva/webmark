
/* Codigo para la pistola laser, este listener capta el submit de un <form>
 ya en un boton normal sin form no le da enter con la pistola, peticion por post ya que manda el codigo de barra */

document.addEventListener('DOMContentLoaded', function(){
    document.getElementById("codigodebarrastxt").focus();
    let formcodigo = document.getElementById("formcodigo");
    formcodigo.addEventListener("submit", function(e){
        let codigodebarras = document.querySelector("#codigodebarrastxt").value;
        e.preventDefault();
        let nuevoproducto = {};
        nuevoproducto.codigo = codigodebarras;
        //console.log(codigodebarras);
        let formData = new FormData();
        formData.append('codigodebarra', nuevoproducto.codigo)
        axios.post('/productos/codigodebarra', formData).then(function(respuesta){
            console.log(respuesta.data);
        });
        document.getElementById("codigodebarrastxt").value = "";
    });
});


/*TEST

document.getElementById("btn-producto").addEventListener("click", function(e){
    axios.get('productos/codigodebarra').then(function(respuesta){
        console.log(respuesta.data);
    });
});*/
