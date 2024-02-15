/**
 * Funciones auxiliares de javascripts 
 */
function confirmarBorrar(nombre,id){
  if (confirm("¿Quieres eliminar el cliente:  "+nombre+"?"))
  {
   document.location.href="?orden=Borrar&id="+id;
  }
}

  function initMap(vlat,vlng) {
    map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: vlat, lng: vlng},
      zoom: 13,
    });
}