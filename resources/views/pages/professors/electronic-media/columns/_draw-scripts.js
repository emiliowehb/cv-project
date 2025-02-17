// Initialize KTMenu
KTMenu.init();

document.querySelectorAll('[data-kt-action="delete_media"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Swal.fire({
            text: 'Are you sure you want to delete this medium?',
            icon: 'warning',
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('delete_media', [this.getAttribute('data-kt-media-id')]);
            }
        });
    });
});

// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="update_media"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.dispatch('update_media', [this.getAttribute('data-kt-media-id')]);
    });
});

// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the users-table datatable
    LaravelDataTables['professor-electronic-media-table'].ajax.reload();
});
