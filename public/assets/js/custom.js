// delete item
function submitDeleteForm(id) {
    if (confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
        document.getElementById('delete-form-' + id).submit();
    } else {
        return false;
    }
}

window.onload = function() {
    const alert = document.getElementById('msg_alert');
    if (alert) {
        setTimeout(function() {
            alert.style.display = 'none';
        }, 2000);
    }
};
