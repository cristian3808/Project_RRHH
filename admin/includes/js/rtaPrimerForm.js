// Function to handle form submission
function handleFormSubmission(event) {
    event.preventDefault();  // Prevent the default form submission behavior

    const selectedUsers = document.querySelectorAll('input[name="usuarios[]"]:checked');
    
    if (selectedUsers.length === 0) {
        showToast('Por favor seleccione al menos un usuario', 'error');
        return;
    }

    // Disable the submit button to prevent multiple submissions
    const submitButton = event.target.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.disabled = true;
    }

    // If users are selected, proceed with form submission
    fetch(event.target.action, {
        method: 'POST',
        body: new FormData(event.target)
    })
    .then(response => response.text())
    .then(() => {
        showToast('Correos enviados exitosamente');
        cerrarFormulario(); // Close the form after successful sending
    })
    .catch(() => {
        showToast('Error al enviar los correos', 'error');
    })
    .finally(() => {
        // Enable the submit button again after the process is finished
        if (submitButton) {
            submitButton.disabled = false;
        }
    });
}

// Update the existing cerrarFormulario function to work with the toast
function cerrarFormulario() {
    const formulario = document.getElementById('formularioUsuarios');
    formulario.classList.add('hidden');  // Hide the form
}

// Function to show the form
function mostrarFormularioUsuarios() {
    const formulario = document.getElementById('formularioUsuarios');
    formulario.classList.remove('hidden');  // Show the form
}

// Show toast message with given message and type (success or error)
function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toast-container');
    
    // Ensure container exists
    if (!toastContainer) {
        console.error('Toast container not found!');
        return;
    }

    const toast = document.createElement('div');
    toast.className = `transform transition-all duration-300 ease-in-out ${
        type === 'success' 
            ? 'bg-green-500'
            : 'bg-red-500'
    } text-white px-6 py-4 rounded-lg shadow-lg mb-3 flex items-center opacity-0 translate-y-2`;

    // Create icon based on type
    const icon = document.createElement('span');
    icon.className = 'mr-2';
    icon.innerHTML = type === 'success' ? '✓' : '✕';

    const text = document.createElement('span');
    text.textContent = message;

    toast.appendChild(icon);
    toast.appendChild(text);
    toastContainer.appendChild(toast);

    // Animate in
    requestAnimationFrame(() => {
        toast.classList.remove('opacity-0', 'translate-y-2');
    });

    // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-2');
        setTimeout(() => {
            toastContainer.removeChild(toast);
        }, 300);
    }, 3000);
}

// Add event listeners once DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // User form submission
    const emailForm = document.querySelector('form[action*="envioCorreo2.php"]');
    if (emailForm) {
        emailForm.addEventListener('submit', handleFormSubmission);
    }
});

