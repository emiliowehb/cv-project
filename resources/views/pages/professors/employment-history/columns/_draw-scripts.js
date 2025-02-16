// Initialize KTMenu
KTMenu.init();

document.querySelectorAll('[data-kt-action="delete_employment"]').forEach(function (element) {
    console.log('test');
    element.addEventListener('click', function () {
        Swal.fire({
            text: 'Are you sure you want to delete this employment?',
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
                Livewire.dispatch('delete_employment', [this.getAttribute('data-kt-employment-id')]);
            }
        });
    });
});

// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="update_employment"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.dispatch('update_employment', [this.getAttribute('data-kt-employment-id')]);
    });
});

// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the users-table datatable
    LaravelDataTables['professor-employment-history-table'].ajax.reload();
});
