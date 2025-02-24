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
                location.reload(); // Recargar la página para ver el nuevo proyecto
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
                location.reload(); // Recargar la página para ver el proyecto editado
            }
        };
        xhr.send('edit_id=' + id + '&edit_title=' + encodeURIComponent(title));
        closeEditModal();
    }
}
