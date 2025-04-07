function mostrarFormularioUsuarios() {
    document.getElementById("formularioUsuarios").style.display = "flex";
}

function cerrarFormulario() {
    document.getElementById("formularioUsuarios").style.display = "none";
}

function openModal() {
    document.getElementById("userModal").classList.remove("hidden");
}

function closeModal() {
    document.getElementById("userModal").classList.add("hidden");
}

function openEditModal(id, nombre, apellido, cedula, correo) {
    document.getElementById("editUserModal").classList.remove("hidden");
    document.getElementById("editUserId").value = id;
    document.getElementById("editNombre").value = nombre;
    document.getElementById("editApellido").value = apellido;
    document.getElementById("editCedula").value = cedula;
    document.getElementById("editCorreo").value = correo;
}

function closeEditModal() {
    document.getElementById("editUserModal").classList.add("hidden");
}

function openDeleteModal(id) {
    document.getElementById("deleteUserModal").classList.remove("hidden");
    document.getElementById("deleteUserId").value = id;
}

function closeDeleteModal() {
    document.getElementById("deleteUserModal").classList.add("hidden");
}

function validateCedula(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
    if (input.value.length > 10) {
        input.value = input.value.slice(0, 10);
    }
}

window.onload = function () {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const message = urlParams.get('message');
    const alertModal = document.getElementById('alertModal');
    const alertTitle = document.getElementById('alertTitle');
    const alertMessage = document.getElementById('alertMessage');
    const alertIcon = document.getElementById('alertIcon');

    if (status === 'success') {
        alertTitle.textContent = '¡Correo enviado!';
        alertMessage.textContent = 'Los correos se han enviado correctamente.';
        alertIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
        alertModal.classList.remove('hidden');
    } else if (status === 'error') {
        alertTitle.textContent = 'Hubo un problema';
        alertMessage.textContent = message || 'Ocurrió un error al enviar los correos.';
        alertIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
        alertModal.classList.remove('hidden');
    }

    document.getElementById('closeModal').addEventListener('click', function () {
        alertModal.classList.add('hidden');
    });

    setTimeout(function () {
        alertModal.classList.add('hidden');
    }, 5000);
};

// Creaar toast
function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toast-container');
    
    const toast = document.createElement('div');
    toast.className = `transform transition-all duration-300 ease-in-out ${
        type === 'success' 
            ? 'bg-green-500'
            : 'bg-red-500'
    } text-white px-6 py-4 rounded-lg shadow-lg mb-3 flex items-center`;
    
    const icon = document.createElement('span');
    icon.className = 'mr-2';
    icon.innerHTML = type === 'success' 
        ? '✓'
        : '✕';
    
    const text = document.createElement('span');
    text.textContent = message;
    
    toast.appendChild(icon);
    toast.appendChild(text);
    
    // Add to container
    toastContainer.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('translate-y-0', 'opacity-100');
    }, 100);
    
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-2');
        setTimeout(() => {
            toastContainer.removeChild(toast);
        }, 300);
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function() {
    const emailForm = document.querySelector('form[action*="envioCorreo1.php"]');
    if (emailForm) {
        emailForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const selectedUsers = document.querySelectorAll('input[name="usuarios[]"]:checked');
            
            if (selectedUsers.length === 0) {
                showToast('Por favor seleccione al menos un usuario', 'error');
                return;
            }
            
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.text())
            .then(() => {
                showToast('Correos enviados exitosamente');
                cerrarFormulario(); 
            })
            .catch(() => {
                showToast('Error al enviar los correos', 'error');
            });
        });
    }
});

// Para el campo "Nombres"
document.querySelector('input[name="nombres"]').addEventListener('input', function () {
    this.value = this.value.replace(/\b\w/g, char => char.toUpperCase()) // Capitaliza la primera letra de cada palabra
                           .replace(/([a-zA-ZáéíóúÁÉÍÓÚ])([A-Z]+)/g, (match, firstChar, restOfWord) => firstChar + restOfWord.toLowerCase()); // Convierte las letras restantes a minúsculas
});

// Para el campo "Apellidos"
document.querySelector('input[name="apellidos"]').addEventListener('input', function () {
    this.value = this.value.replace(/\b\w/g, char => char.toUpperCase()) // Capitaliza la primera letra de cada palabra
                           .replace(/([a-zA-ZáéíóúÁÉÍÓÚ])([A-Z]+)/g, (match, firstChar, restOfWord) => firstChar + restOfWord.toLowerCase()); // Convierte las letras restantes a minúsculas
});

// Función para mostrar el menú en móviles
document.getElementById('menuToggle').addEventListener('click', function() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
});

// Mostrar el formulario de usuarios
function mostrarFormularioUsuarios() {
    document.getElementById('formularioUsuarios').classList.remove('hidden');
}

// Cerrar el formulario de usuarios
function cerrarFormulario() {
    document.getElementById('formularioUsuarios').classList.add('hidden');
}