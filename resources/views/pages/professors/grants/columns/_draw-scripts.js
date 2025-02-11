// Initialize KTMenu
KTMenu.init();

document.querySelectorAll('[data-kt-action="delete_grant"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Swal.fire({
            text: 'Are you sure you want to delete this grant?',
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
                Livewire.dispatch('delete_grant', [this.getAttribute('data-kt-grant-id')]);
            }
        });
    });
});

// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="update_grant"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.dispatch('update_grant', [this.getAttribute('data-kt-grant-id')]);
    });
});

// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the grants-table datatable
    LaravelDataTables['professor-grants-table'].ajax.reload();
});
