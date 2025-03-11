<?php 
require('../../../config/db.php');

// Recupera los correos registrados
$sql = "SELECT correo FROM usuarios";
$result = $conn->query($sql);
$correos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $correos[] = $row['correo'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Cristian Alejandro Jiménez Mora">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Formulario</title>
</head>
<body class="flex items-center justify-center min-h-screen bg-[#E1EEE2]">
<form id="formUsuario" action="../../controllers/guardarUsuariosForm1.php" method="POST" enctype="multipart/form-data" class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-md border border-black w-11/12 max-w-5xl">
        <div class="flex justify-center mb-4">
            <img src="/static/img/TF.png" alt="Logo-TF" class="h-16">
        </div>
        <h1 class="text-left font-bold text-lg md:text-xl mt-[10px] mb-5">Datos de la persona.</h1>

        <div class="grid gap-4 grid-cols-1 md:grid-cols-4">
            
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-1">1. Nombres</label>
                <input id="nombres" name="nombres" type="text" class="border border-gray-300 rounded py-1 px-2 text-xs " maxlength="30" required>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-1">2. Apellidos</label>
                <input id="apellidos" name="apellidos" type="text" class="border border-gray-300 rounded py-1 px-2 text-xs " maxlength="30" required>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-1 ">3. Cédula</label>
                <input name="cedula" type="text" class="border border-gray-300 rounded py-1 px-2 text-xs" maxlength="10" required>
            </div>
            <div class="flex flex-col ">
                <label class="custom-font text-xs mb-1">4. Tipo de sangre</label>
                <select name="tipo_sangre" class="border border-gray-300 rounded py-1 px-2 text-xs" required>
                    <option value="" disabled selected>Selecciona tu tipo de sangre</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-1">5. Fecha de nacimiento</label>
                <input name="fecha_nacimiento" type="date" class="border border-gray-300 rounded py-1 px-2 text-xs" required>
            </div>
            <div class="flex flex-col">
                <label for="lugar_nacimiento" class="custom-font text-xs mb-1">7. Lugar de nacimiento</label>
                <select id="lugar_nacimiento" name="lugar_nacimiento"
                    class="border border-gray-300 rounded py-1 px-2 text-xs appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                    aria-placeholder="ola" required>
                    <option value=""></option>
                </select>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-1">8. Fecha de expedición de la cédula</label>
                <input name="fecha_expedicion_cedula" type="date" class="border border-gray-300 rounded py-1 px-2 text-xs" required>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-sm mb-4">9. Género</label>
                <select id="genero" name="genero" class="border border-gray-300 rounded py-1 px-2 text-sm -mt-[15px]" required>
                    <option value="">Selecciona tu género</option>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-1">10. Teléfono</label>
                <input name="telefono" type="text" class="border border-gray-300 rounded py-1 px-2 text-xs" required>
            </div>
            <div class="flex flex-col ">
                <label class="custom-font text-xs mb-1">11. Correo</label>
                <input name="correo" type="text" class="border border-gray-300 rounded py-1 px-2 text-xs" required>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-1">12. Dirección</label>
                <input type="text" id="direccion" name="direccion" class="border border-gray-300 rounded py-1 px-2 text-xs" placeholder="Selecciona..." readonly onclick="abrirModalDireccion()" required>
            </div>
            <div class="flex flex-col ">
                <label class="custom-font text-xs mb-1">13. Ciudad de residencia</label>
                <select id="municipio_residencia" name="municipio_residencia"
                    class="border border-gray-300 rounded py-1 px-2 text-xs appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                    aria-placeholder="ola" required>
                    <option value=""></option>
                </select>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs">14. EPS</label>
                <select name="eps" class="border border-gray-300 rounded py-1 px-2 text-xs uppercase" required>
                    <option value="" disabled selected>Selecciona una EPS</option>
                    <option value="NUEVA EPS">NUEVA EPS</option>
                    <option value="SANITAS">SANITAS</option>
                    <option value="SURA">SURA</option>
                    <option value="COMPENSAR">COMPENSAR</option>
                    <option value="SALUD TOTAL">SALUD TOTAL</option>
                    <option value="COOSALUD">COOSALUD</option>
                    <option value="FAMISANAR">FAMISANAR</option>
                    <option value="CAPITAL SALUD">CAPITAL SALUD</option>
                    <option value="MUTUAL SER">MUTUAL SER</option>
                    <option value="ECOOPSOS">ECOOPSOS</option>
                    <option value="ASMET SALUD">ASMET SALUD</option>
                    <option value="EMSSANAR">EMSSANAR</option>
                    <option value="DUSAKAWI">DUSAKAWI</option>
                    <option value="SAVIA SALUD">SAVIA SALUD</option>
                    <option value="NUEVA EPS">NUEVA EPS</option>
                    <option value="ALIANSALUD">ALIANSALUD</option>
                    <option value="FOSYGA">FOSYGA</option>
                    <option value="CONFACUNDI">CONFACUNDI</option>
                    <option value="CAPRESOCA">CAPRESOCA</option>
                    <option value="CAJACOPI">CAJACOPI</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs -mt-[-1px]">15. AFP FONDO DE PENSIONES</label>
                <select name="fondo_pension" class="border border-gray-300 rounded py-1 px-2 text-xs" required>
                    <option value=""disable selected>Selecciona tu AFP</option>
                    <option value="Porvenir">Porvenir</option>
                    <option value="Protección">Protección</option>
                    <option value="Colpatria">Colpatria</option>
                    <option value="Fiduciaria de Bancolombia">Fiduciaria de Bancolombia </option>
                    <option value="Old Mutual">Old Mutual</option>
                    <option value="Colpensiones">Colpensiones</option>
                    <option value="Skandia">Skandia</option>
                    <option value="Suramericana">Suramericana</option>
                    <option value="Colfondos">Colfondos</option>
                    <option value="Aseguradora de Vida Suramericana">Aseguradora de Vida Suramericana</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs ">16. ARL</label>
                <input name="arl" type="text" class="border border-gray-300 rounded py-1 px-2 text-xs bg-zinc-200" value="AXA COLPATRIA" readonly required>
            </div>
            <div class="flex flex-col ">
                <label class="custom-font text-xs mb-1">17. Contacto en caso de emergencia</label>
                <input name="nombre_contacto" type="text" placeholder="Nombre" class="border border-gray-300 rounded py-1 px-2 text-xs mb-2" required>
                <input name="telefono_contacto" type="text" placeholder="Teléfono" class="border border-gray-300 rounded py-1 px-2 text-xs" required>
            </div>
        </div>
        <h1 class="text-left font-bold text-lg md:text-xl mt-[10px] mb-5">
            Por favor subir los Documentos en <span class="text-red-600">(PDF)</span>.
        </h1>
        <div class=" grid gap-4 grid-cols-1 md:grid-cols-4"> 
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-1">18. Hoja de vida actual.<br>(Máximo 3 Hojas)</label>
                <input name="hoja_vida" type="file" accept="application/pdf" class="border border-gray-300 rounded py-1 px-2 text-xs" required>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-1">19. Cédula.<br>(Máximo 1 Hoja)</label>
                <input name="subir_cedula" type="file" accept="application/pdf" class="border border-gray-300 rounded py-1 px-2 text-xs" required>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-5">20. Certificados de estudio </label>
                <input name="certificados_estudio" type="file" accept="application/pdf" class="border border-gray-300 rounded py-1 px-2 text-xs" required>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-5">21. Certificados laborales</label>
                <input name="certificados_laborales" type="file" accept="application/pdf" class="border border-gray-300 rounded py-1 px-2 text-xs" required>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-1">22. Foto fondo blanco (3x4)<br>(Máximo 1 Hoja)</label>
                <input name="foto" type="file" accept="image/jpg, image/jpeg, image/png" class="border border-gray-300 rounded py-1 px-2 text-xs" required>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-1">23. Certificado EPS<br>(Máximo 1 Hoja)</label>
                <input name="certificados_eps" type="file" accept="application/pdf" class="border border-gray-300 rounded py-1 px-2 text-xs" required>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-1">24. Carnet vacunas<br>(Máximo 5 Hojas)</label>
                <input name="carnet_vacunas" type="file" accept="application/pdf" class="border border-gray-300 rounded py-1 px-2 text-xs" required>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-1">25. Certificacion bancaria<br>(Máximo 1 Hoja)</label>
                <input name="certificacion_bancaria" type="file" accept="application/pdf" class="border border-gray-300 rounded py-1 px-2 text-xs" required>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-1">26. Certificado antecedentes<br>(Máximo 1 Hoja)</label>
                <input name="certificado_antecedentes" type="file" accept="application/pdf" class="border border-gray-300 rounded py-1 px-2 text-xs" required>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-1">27. Certificado AFP<br>(Máximo 1 Hoja)</label>
                <input name="certificado_afp" type="file" accept="application/pdf" class="border border-gray-300 rounded py-1 px-2 text-xs" required>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-1 flex items-center whitespace-nowrap">
                    23. Certificado territorialidad<br>(Máximo 1 Hoja) 
                    <span class="text-red-600">(Opcional)</span>
                </label>
                <input name="certificados_territorialidad" type="file" accept="application/pdf" class="border border-gray-300 rounded py-1 px-2 text-xs">
            </div>
            <!-- <div class="flex flex-col">
                <label class="custom-font text-xs mb-1">22. Codigo del municipio</label>
                <input id="codigo_municipio" name="codigo_municipio" type="text" class="border border-gray-300 rounded py-1 px-2 text-xs " readonly>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-xs mb-1">22. Codigo del departamento</label>
                <input id="codigo_departamento" name="codigo_departamento" type="text" class="border border-gray-300 rounded py-1 px-2 text-xs " readonly>
            </div> -->
        </div>
        <div  class=" grid gap-4 grid-cols-1 md:grid-cols-4 mt-[20px]">
            <div class="flex flex-col">
                <label class="custom-font text-sm mb-2">26. Talla de Camisa</label>
                <select id="talla_camisa" name="talla_camisa" class="border border-gray-300 rounded py-2 px-3 text-sm" >
                    <option value="" disabled selected>Selecciona tu talla</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                    <option value="XXXL">XXXL</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-sm mb-2">27. Talla de Pantalón</label>
                <select id="talla_pantalon" name="talla_pantalon" class="border border-gray-300 rounded py-2 px-3 text-sm" >
                    <option value="" disabled selected>Selecciona tu talla</option>
                    <option value="28">28</option>
                    <option value="30">30</option>
                    <option value="32">32</option>
                    <option value="34">34</option>
                    <option value="36">36</option>
                    <option value="38">38</option>
                    <option value="40">40</option>
                    <option value="42">42</option>
                    <option value="44">44</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-sm mb-2">28. Talla de Botas</label>
                <select id="talla_botas" name="talla_botas" class="border border-gray-300 rounded py-2 px-3 text-sm" >
                    <option value="" disabled selected>Selecciona tu talla</option>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                    <option value="41">41</option>
                    <option value="42">42</option>
                    <option value="43">43</option>
                    <option value="44">44</option>
                    <option value="45">45</option>
                    <option value="46">46</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label class="custom-font text-sm mb-2">29. Talla de Nomex</label>
                <select id="talla_nomex" name="talla_nomex" class="border border-gray-300 rounded py-2 px-3 text-sm" >
                    <option value="" disabled selected>Selecciona tu talla</option>
                    <option value="34">34</option>
                    <option value="36">36</option>
                    <option value="38">38</option>
                    <option value="40">40</option>
                    <option value="42">42</option>
                    <option value="44">44</option>
                    <option value="46">46</option>
                    <option value="48">48</option>
                    <option value="50">50</option>
                    <option value="52">52</option>
                </select>
            </div>
        </div>
        
        <div class="mt-4 flex justify-center">
            <button type="submit" class="bg-green-600 hover:bg-lime-500 text-white font-bold py-2 px-4 rounded-lg shadow-md transition transform hover:scale-105">
                Enviar
            </button>
        </div>
    </div>
</form>
<!-- Botón para abrir el modal -->
<button id="btnAbrirModal" class="bg-[#EAE9E5] text-black px-4 py-2 border-2 border-black rounded flex items-center space-x-2 relative top-[260px] left-[-270px]">
    <img src="/admin/includes/imgs/guia_tallas.png" alt="" class="w-6 h-6"> <!-- Tamaño de la imagen ajustado -->
    <span>Ver Guia De Tallas</span> <!-- El texto -->
</button>

<!-- Modal con imágenes -->
<div id="modalImagenes" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center">
    <div class="bg-white p-4 rounded-lg relative w-full max-w-7xl">
        <!-- Botón de cierre -->
        <button id="cerrarModal" class="absolute top-[-40px] right-[-25px] text-red-500 text-3xl w-[40px] h-[40px] flex items-center justify-center rounded-full bg-white border-2 border-black">&times;</button>

        <!-- Contenedor de imágenes -->
        <div class="grid grid-cols-3 gap-6">
            <img src="/admin/includes/imgs/guiatallascamisacaballero.png" class="rounded-lg object-cover transform transition-transform duration-300 hover:scale-110" style="width: 800px; height: auto; border: 2px solid #000000;">
            <img src="/admin/includes/imgs/guiatallaspantaloncaballero.png" class="rounded-lg object-cover transform transition-transform duration-300 hover:scale-110" style="width: 800px; height: auto; border: 2px solid #000000;">
            <img src="/admin/includes/imgs/guiatallascamisadama.png" class="rounded-lg object-cover transform transition-transform duration-300 hover:scale-110" style="width: 800px; height: auto; border: 2px solid #000000;">
            <img src="/admin/includes/imgs/guiatallaspantalondama.png" class="rounded-lg object-cover transform transition-transform duration-300 hover:scale-110" style="width: 800px; height: auto; border: 2px solid #000000;">
            <img src="/admin/includes/imgs/guiatallasbotas.png" class="rounded-lg object-cover transform transition-transform duration-300 hover:scale-110" style="width: 800px; height: auto; border: 2px solid #000000;">
            <img src="/admin/includes/imgs/guiatallasnomex.png" class="rounded-lg object-cover transform transition-transform duration-300 hover:scale-110" style="width: 900px; height: auto; border: 2px solid #000000;">
        </div>
    </div>
</div>
<script>
    document.getElementById('btnAbrirModal').addEventListener('click', function() {
        document.getElementById('modalImagenes').classList.remove('hidden');
    });

    document.getElementById('cerrarModal').addEventListener('click', function() {
        document.getElementById('modalImagenes').classList.add('hidden');
    });
</script>


<script>
    document.getElementById("genero").addEventListener("change", function() {
        var genero = this.value;
        
        if (genero === "femenino") {
            // Cambiar tallas para femenino
            document.getElementById("talla_camisa").innerHTML = `
                <option value="" disabled selected>Selecciona tu talla</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
                <option value="XXL">XXL</option>
            `;
            document.getElementById("talla_pantalon").innerHTML = `
                <option value="" disabled selected>Selecciona tu talla</option>
                <option value="6">6</option>
                <option value="8">8</option>
                <option value="10">10</option>
                <option value="12">12</option>
                <option value="14">14</option>
                <option value="16">16</option>
                <option value="18">18</option>
                <option value="20">20</option>
                <option value="22">22</option>
            `;
            document.getElementById("talla_botas").innerHTML = `
                <option value="" disabled selected>Selecciona tu talla</option>
                <option value="35">35</option>
                <option value="36">36</option>
                <option value="37">37</option>
                <option value="38">38</option>
            `;
            document.getElementById("talla_nomex").innerHTML = `
                <option value="" disabled selected>Selecciona tu talla</option>
                <option value="34">34</option>
                <option value="36">36</option>
                <option value="38">38</option>
                <option value="40">40</option>
            `;
        } else if (genero === "masculino") {
            // Cambiar tallas para masculino
            document.getElementById("talla_camisa").innerHTML = `
                <option value="" disabled selected>Selecciona tu talla</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
                <option value="XXL">XXL</option>
                <option value="XXXL">XXXL</option>
            `;
            document.getElementById("talla_pantalon").innerHTML = `
                <option value="" disabled selected>Selecciona tu talla</option>
                <option value="28">28</option>
                <option value="30">30</option>
                <option value="32">32</option>
                <option value="34">34</option>
                <option value="36">36</option>
                <option value="38">38</option>
                <option value="40">40</option>
                <option value="42">42</option>
                <option value="44">44</option>
            `;
            document.getElementById("talla_botas").innerHTML = `
                <option value="" disabled selected>Selecciona tu talla</option>
                <option value="39">39</option>
                <option value="40">40</option>
                <option value="41">41</option>
                <option value="42">42</option>
                <option value="43">43</option>
                <option value="44">44</option>
                <option value="45">45</option>
                <option value="46">46</option>
            `;
            document.getElementById("talla_nomex").innerHTML = `
                <option value="" disabled selected>Selecciona tu talla</option>
                <option value="42">42</option>
                <option value="44">44</option>
                <option value="46">46</option>
                <option value="48">48</option>
                <option value="50">50</option>
            `;
        }
    });
</script>

<!-- Modal de respuesta -->
<div id="modal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-md w-full">
        <h2 id="modalMessage" class="text-xl"></h2>
        <button id="btnCorregir" onclick="closeModal()" class="mt-4 bg-blue-400 text-white py-2 px-6 rounded-lg hidden">
            Corregir
        </button>
        <button id="btnTerminar" onclick="terminart()" class="mt-4 bg-red-500 text-white py-2 px-6 rounded-lg">
            Terminar
        </button>
    </div>          
</div>

    <!-- Modal para dirección -->
    <div id="modalDireccion" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-3xl relative">
            <button 
                onclick="cerrarModalDireccion()" 
                class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 font-bold text-xl">
                &times;
            </button>
            <p class="text-center text-gray-600 mb-6">Ingreso Dirección</p>
            <div id="detallesDireccionLimpio" class="bg-[#F5F5F5] p-4 mb-4 rounded-md text-gray-700 font-medium text-center h-14 border border-[#CCCCCC]">
            </div>
            <form oninput="actualizarDireccion()">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="via" class="block text-sm font-medium text-gray-700">Vía <span class="text-red-500">*</span>:</label>
                        <select id="via" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value=""></option>
                            <option value="AV">AVENIDA</option>
                            <option value="CL">CALLE</option>
                            <option value="CR">CARRERA</option>
                            <option value="CIR">CIRCULAR</option>
                            <option value="CRV">CIRCUNVALAR</option>
                            <option value="DG">DIAGONAL</option>
                            <option value="TV">TRANSVERSAL</option>
                        </select>
                    </div>
                    <div>
                        <label for="numero1" class="block text-sm font-medium text-gray-700">Número <span class="text-red-500">*</span>:</label>
                        <input type="text" id="numero1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="letra1" class="block text-sm font-medium text-gray-700">Letra :</label>
                        <select id="letra1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option></option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                            <option value="K">K</option>
                            <option value="L">L</option>
                            <option value="M">M</option>
                            <option value="N">N</option>
                            <option value="O">O</option>
                            <option value="P">P</option>
                            <option value="Q">Q</option>
                            <option value="R">R</option>
                            <option value="S">S</option>
                            <option value="T">T</option>
                            <option value="U">U</option>
                            <option value="V">V</option>
                            <option value="W">W</option>
                            <option value="X">X</option>
                            <option value="Y">Y</option>
                            <option value="Z">Z</option>
                        </select>
                    </div>
                    <div>
                        <label for="bis" class="block text-sm font-medium text-gray-700">BIS :</label>
                        <select id="bis" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option></option>
                            <option value="BIS">BIS</option>
                        </select>
                    </div>
                    <div>
                        <label for="complemento1" class="block text-sm font-medium text-gray-700">Complemento :</label>
                        <select id="complemento1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option></option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                            <option value="K">K</option>
                            <option value="L">L</option>
                            <option value="M">M</option>
                            <option value="N">N</option>
                            <option value="O">O</option>
                            <option value="P">P</option>
                            <option value="Q">Q</option>
                            <option value="R">R</option>
                            <option value="S">S</option>
                            <option value="T">T</option>
                            <option value="U">U</option>
                            <option value="V">V</option>
                            <option value="W">W</option>
                            <option value="X">X</option>
                            <option value="Y">Y</option>
                            <option value="Z">Z</option>
                        </select>
                    </div>
                    <div >
                        <label for="cardinalidad1" class="block text-sm font-medium text-gray-700">Cardinalidad :</label>
                        <select id="cardinalidad1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option></option>
                            <option value="NORTE">NORTE</option>
                            <option value="SUR">SUR</option>
                            <option value="ESTE">ESTE</option>
                            <option value="OESTE">OESTE</option>
                            <option value="NOROESTE">NOROESTE</option>
                            <option value="NORESTE">NORESTE</option>
                            <option value="SUROESTE">SUROESTE</option>
                            <option value="SURESTE">SURESTE</option>
                        </select>
                    </div>
                    <div>
                        <label for="hash" class="block text-sm font-medium text-gray-700"><br></label>
                        <input type="text" id="hash" value="#" readonly 
                            class="mt-1 block w-full text-center bg-transparent border-none sm:text-sm"
                            style="user-select: none; pointer-events: none;">   
                    </div>
                    <div>
                        <label for="numero2" class="block text-sm font-medium text-gray-700">Número <span class="text-red-500">*</span>:</label>
                        <input type="text" id="numero2" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="letra2" class="block text-sm font-medium text-gray-700">Letra :</label>
                        <select id="letra2" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option></option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                            <option value="K">K</option>
                            <option value="L">L</option>
                            <option value="M">M</option>
                            <option value="N">N</option>
                            <option value="O">O</option>
                            <option value="P">P</option>
                            <option value="Q">Q</option>
                            <option value="R">R</option>
                            <option value="S">S</option>
                            <option value="T">T</option>
                            <option value="U">U</option>
                            <option value="V">V</option>
                            <option value="W">W</option>
                            <option value="X">X</option>
                            <option value="Y">Y</option>
                            <option value="Z">Z</option>
                        </select>
                    </div>
                    <div>
                        <label for="guion" class="block text-sm font-medium text-gray-700"><br></label>
                        <input type="text" id="guion" value="-" readonly 
                            class="mt-1 block w-full text-center bg-transparent border-none sm:text-sm"
                            style="user-select: none; pointer-events: none;">
                    </div>
                    <div>
                        <label for="complemento2" class="block text-sm font-medium text-gray-700">Complemento <span class="text-red-500">*</span>:</label>
                        <input type="text" id="complemento2" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="cardinalidad2" class="block text-sm font-medium text-gray-700">Cardinalidad :</label>
                        <select id="cardinalidad2" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option></option>
                            <option value="NORTE">NORTE</option>
                            <option value="SUR">SUR</option>
                            <option value="ESTE">ESTE</option>
                            <option value="OESTE">OESTE</option>
                            <option value="NOROESTE">NOROESTE</option>
                            <option value="NORESTE">NORESTE</option>
                            <option value="SUROESTE">SUROESTE</option>
                            <option value="SURESTE">SURESTE</option>
                        </select>
                    </div>
                    <div>
                        <label for="vivienda" class="block text-sm font-medium text-gray-700">Vivienda :</label>
                        <select id="vivienda" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option></option>
                            <option value="APARTAMENTO">APARTAMENTO</option>
                            <option value="CASA">CASA</option>
                            <option value="BODEGA">BODEGA</option>
                            <option value="PISO">PISO</option>
                            <option value="SUITE">SUITE</option>
                            <option value="ESTUDIO">ESTUDIO</option>
                        </select>
                    </div>
                    <div>
                        <label for="numero_vivienda" class="block text-sm font-medium text-gray-700">Número de vivienda :</label>
                        <input type="text" id="numero_vivienda" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
                <!-- Campo donde se irá anotando la dirección -->
                <div id="detallesDireccion" class="bg-[#E1EEE2] p-4 mb-4 rounded-md text-gray-700 font-medium text-center h-14 border border-green-300">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="guardarDireccion(event)" class="bg-blue-500 text-white py-2 px-4 rounded">Guardar Dirección</button>
                </div>
            </form>
        </div>
    </div>
<script>
$(document).ready(function() {
    $('#formUsuario').on('submit', function(e) {
        e.preventDefault(); // Evita el envío normal del formulario
        var formData = new FormData(this);

        $.ajax({
            url: '../../controllers/guardarUsuariosForm1.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#modalMessage').text(response);
                $('#modal').removeClass('hidden');

                if (response.includes("La cédula ya está registrada") || response.includes("Datos registrados exitosamente")) {
                    $('#btnCorregir').hide();
                    $('#btnTerminar').show();
                } else if (response.includes("Error")) {
                    $('#btnCorregir').show();  // Mostrar botón de corregir
                    $('#btnTerminar').hide();  // Ocultar botón de terminar hasta que se corrija
                } else {
                    $('#btnCorregir').hide();
                    $('#btnTerminar').show();
                }
            }
        });
    });

    $('#btnCorregir').on('click', function() {
        $('#modal').addClass('hidden'); // Cerrar modal para corregir errores
    });
});

function terminart() {
    $('#modal').addClass('hidden');
    window.location.href = 'https://tfauditores.com/';
}

function closeModal() {
    $('#modal').addClass('hidden');
}



const seleccione = document.getElementById('seleccione');
const correoLista = document.getElementById('correo-lista');

// Alterna la visibilidad de la lista al hacer clic en "Seleccione"
seleccione.addEventListener('click', () => {
    correoLista.classList.toggle('hidden');
});

// Maneja la selección de un correo
correoLista.addEventListener('click', (event) => {
    if (event.target && event.target.matches('li.selectable-item')) {
        // Inserta el correo seleccionado en el texto de "Seleccione"
        seleccione.textContent = event.target.textContent;
        // Oculta la lista nuevamente
        correoLista.classList.add('hidden');
    }
}); 

// Función para abrir la modal de dirección
function abrirModalDireccion() {
    document.getElementById('modalDireccion').classList.remove('hidden');
}

function cerrarModalDireccion() {
    document.getElementById('modalDireccion').classList.add('hidden');
}
function actualizarDireccion() {
function getSelectValue(id) {
    let select = document.getElementById(id);
    let value = select.value.trim();
    return value && value !== "" ? value : "";
}

function getSelectText(id) {
    let select = document.getElementById(id);
    let text = select.options[select.selectedIndex].text.trim();
    return text && text !== "" ? text : "";
}

function getInputValue(id) {
    return document.getElementById(id).value.trim();
}
    // Capturar valores con value
    let via = getSelectValue('via');
    let letra = getSelectValue('letra1');
    let bis = getSelectValue('bis');
    let cardinalidad = getSelectValue('cardinalidad1');
    let letra2 = getSelectValue('letra2');
    let cardinalidad2 = getSelectValue('cardinalidad2');
    let vivienda = getSelectValue('vivienda');

    // Capturar textos visibles con text
    let viaText = getSelectText('via');
    let letraText = getSelectText('letra1');
    let bisText = getSelectText('bis');
    let cardinalidadText = getSelectText('cardinalidad1');
    let letra2Text = getSelectText('letra2');
    let cardinalidad2Text = getSelectText('cardinalidad2');
    let viviendaText = getSelectText('vivienda');

    // Capturar valores de inputs
    let numero = getInputValue('numero1');
    let complemento = getInputValue('complemento1');
    let numero2 = getInputValue('numero2');
    let complemento2 = getInputValue('complemento2');
    let numero_vivienda = getInputValue('numero_vivienda');

    // Construcción de la dirección sin símbolos
    let direccionPartes = [via, numero, letra, bis, complemento, cardinalidad, numero2 ? `${numero2}` : "", letra2, complemento2 ? `${complemento2}` : "", cardinalidad2, vivienda, numero_vivienda];
    let direccion = direccionPartes.filter(part => part !== "").join(" ");

    // Construcción de la dirección con símbolos
    let direccionLimpiaPartes = [viaText, numero, letraText, bisText, complemento, cardinalidadText, numero2 ? `# ${numero2}` : "", letra2Text, complemento2 ? `- ${complemento2}` : "", cardinalidad2Text, viviendaText, numero_vivienda];
    let direccionLimpia = direccionLimpiaPartes.filter(part => part !== "").join(" ");

    // Mostrar las direcciones en los campos correspondientes
    document.getElementById('detallesDireccionLimpio').textContent = direccionLimpia || "";
    document.getElementById('detallesDireccion').textContent = direccion || "";
}

function guardarDireccion(event) {
    event.preventDefault();  // Evita la recarga de la página

    const direccionLimpia = document.getElementById('detallesDireccionLimpio').textContent.trim();
    const direccion = document.getElementById('detallesDireccion').textContent.trim();

    if (!direccionLimpia) {
        alert('Por favor, complete los detalles de la dirección.');
        return;
    }

    // Asignar valores a los campos 
    document.getElementById('direccion').value = direccion;
    console.log('Dirección guardada:', direccion);
    console.log('Dirección en formato limpio guardada:', direccionLimpia);

    // Cerrar el modal
    cerrarModalDireccion();
}
</script>
<script>
    // Para el campo "Nombres"
    document.getElementById('nombres').addEventListener('input', function () {
        this.value = this.value.replace(/\b\w/g, char => char.toUpperCase()) 
            .replace(/([a-zA-ZáéíóúÁÉÍÓÚ])([A-Z]+)/g, (match, firstChar, restOfWord) => firstChar + restOfWord.toLowerCase());
    });

    // Para el campo "Apellidos"
    document.getElementById('apellidos').addEventListener('input', function () {
        this.value = this.value.replace(/\b\w/g, char => char.toUpperCase()) 
            .replace(/([a-zA-ZáéíóúÁÉÍÓÚ])([A-Z]+)/g, (match, firstChar, restOfWord) => firstChar + restOfWord.toLowerCase()); 
    });
</script>
<script>
    const API_URL = 'https://www.datos.gov.co/resource/xdk5-pm3f.json';
    let municipios = [];  

    async function cargarMunicipios() {
        try {
            const response = await fetch(API_URL);
            if (!response.ok) {
                throw new Error(`Error al obtener datos: ${response.statusText}`);
            }

            municipios = await response.json();

            municipios = municipios.map(municipio => {
                const municipioMayusculas = {};
                for (const key in municipio) {
                    if (municipio.hasOwnProperty(key) && typeof municipio[key] === 'string') {
                        municipioMayusculas[key] = municipio[key].toUpperCase();
                    } else {
                        municipioMayusculas[key] = municipio[key];
                    }
                }
                return municipioMayusculas;
            });

            console.log(municipios);
            actualizarSelect(municipios);
        } catch (error) {
            console.error('Error al cargar los municipios:', error);
        }
    }

    function actualizarSelect(municipiosFiltrados) {
        const selectLugarNacimiento = document.getElementById('lugar_nacimiento');
        const selectMunicipioResidencia= document.getElementById('municipio_residencia');
        const clasesOriginalesLugar = selectLugarNacimiento.className;
        const clasesOriginalesResidencia = selectMunicipioResidencia.className;

        // Vaciar las opciones previas y restaurar las clases originales
        selectLugarNacimiento.innerHTML = '<option value=""></option>';
        selectLugarNacimiento.className = clasesOriginalesLugar;
        selectMunicipioResidencia.innerHTML = '<option value=""></option>';
        selectMunicipioResidencia.className = clasesOriginalesResidencia;

        //Ordenar alfabéticamente los municipios
        municipiosFiltrados.sort((a, b) => a.municipio.localeCompare(b.municipio));

        // Crear las nuevas opciones ordenadas
        municipiosFiltrados.forEach(municipio => {
            if (municipio.municipio) {
                const optionLugar = document.createElement('option');
                optionLugar.value = municipio.codigodane || municipio.municipio;
                optionLugar.textContent = municipio.municipio || 'Nombre no disponible';
                selectLugarNacimiento.appendChild(optionLugar);

                const optionResidencia = document.createElement('option');
                optionResidencia.value = municipio.codigodane || municipio.municipio;
                optionResidencia.textContent = municipio.municipio  || 'Nombre no disponible';
                selectMunicipioResidencia.appendChild(optionResidencia);
            }
        });
        
       new Choices(selectLugarNacimiento, {
            searchEnabled: true,
            itemSelectText: '',
            noResultsText: 'No se encontraron resultados',
            placeholderValue: 'Selecciona un municipio',
            classNames: {
                containerOuter: 'border border-gray-300 rounded py-1 px-2 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500',
                containerInner: 'text-xs',
                input: 'py-1 px-2 text-xs',
                listDropdown: 'text-xs',
            }
        });

        new Choices(selectMunicipioResidencia,{
            searchEnabled: true,
            itemSelectText: '',
            noResultsText: 'No se encontraron resultados',
            placeholderValue: 'Selecciona un municipio'
        });
    }

    function manejarSeleccionMunicipio(event) {
        const municipioSeleccionado = event.target.value;
        const municipioEncontrado = municipios.find(municipio => municipio.codigodane === municipioSeleccionado || municipio.municipio.toUpperCase() === municipioSeleccionado.toUpperCase());

        if (municipioEncontrado) {
            document.getElementById('codigo_municipio').value = municipioEncontrado.c_digo_dane_del_municipio || '';
            document.getElementById('codigo_departamento').value = municipioEncontrado.c_digo_dane_del_departamento || '';
        } else {
            document.getElementById('codigo_municipio').value = '';
            document.getElementById('codigo_departamento').value = '';
        }
    }
 
    document.addEventListener('DOMContentLoaded', () => {
        cargarMunicipios();
        document.getElementById('lugar_nacimiento').addEventListener('change', manejarSeleccionMunicipio);  
        document.getElementById('municipio_residencia').addEventListener('change', manejarSeleccionMunicipio);  
    });
</script>
</body>
</html>
