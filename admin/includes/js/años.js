function openModal() {
    document.getElementById('projectModal').classList.remove('hidden');
}
function closeModal() {
    document.getElementById('projectModal').classList.add('hidden');
}
function submitProject() {
    var title = document.getElementById('projectTitle').value;
    if (title) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                location.reload(); 
            }
        };
        xhr.send('title=' + encodeURIComponent(title));
        closeModal();
    }
}
function openEditModal(id, title) {
    document.getElementById('editProjectTitle').value = title;
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').dataset.id = id;
}
function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}
function submitEditProject() {
    var id = document.getElementById('editModal').dataset.id;
    var title = document.getElementById('editProjectTitle').value;
    if (title) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                location.reload(); 
            }
        };
        xhr.send('edit_id=' + id + '&edit_title=' + encodeURIComponent(title));
        closeEditModal();
    }
}
function openDeleteModal(id) {
    document.getElementById('deleteUserId').value = id;
    document.getElementById('deleteUserModal').classList.remove('hidden');
}
function closeDeleteModal() {
    document.getElementById('deleteUserModal').classList.add('hidden');
}

// Función para mostrar el toast
function showToast() {
    const toast = document.getElementById('toast-warning');
    toast.style.display = 'flex'; 
    setTimeout(() => {
        toast.style.display = 'none'; 
    }, 10000); 
}

// Función para cerrar manualmente el toast
const closeButton = document.querySelector('[data-dismiss-target="#toast-warning"]');
closeButton.addEventListener('click', () => {
    const toast = document.getElementById('toast-warning');
    toast.style.display = 'none'; // Oculta el toast al hacer clic en el botón de cerrar
});

window.onload = showToast;