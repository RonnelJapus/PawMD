document.addEventListener('DOMContentLoaded', function() {
    let userIdToDelete = null;

    // Open Modal Function
    function openModal(userId) {
        userIdToDelete = userId;
        document.getElementById('deleteModal').classList.add('active');
    }

    // Close Modal Function
    function closeModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }

    // Event listener for Confirm Delete button
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function () {
            if (userIdToDelete) {
                window.location.href = "delete_account.php?id=" + userIdToDelete;
            }
        });
    }

    // Expose openModal and closeModal globally if needed
    window.openModal = openModal;
    window.closeModal = closeModal;
});
