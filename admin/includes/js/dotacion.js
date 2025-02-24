// Función para ocultar la información y el botón
function ocultarInformacion() {
    var infoDiv = document.getElementById("usuario-info");
    var button = document.getElementById("toggle-button");
    
    // Ocultar la información y eliminar el valor de cédula en el campo de búsqueda
    infoDiv.style.display = "none";
    button.style.display = "none";
    document.getElementById("cedula").value = ''; // Limpiar campo de cédula
}