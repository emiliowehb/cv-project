// Initialize KTMenu
KTMenu.init();

document.querySelectorAll('[data-kt-action="delete_interview"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Swal.fire({
            text: 'Are you sure you want to delete this interview?',
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
                Livewire.dispatch('delete_interview', [this.getAttribute('data-kt-interview-id')]);
            }
        });
    });
});

// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="update_interview"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.dispatch('update_interview', [this.getAttribute('data-kt-interview-id')]);
    });
});

// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the users-table datatable
    LaravelDataTables['professor-interview-table'].ajax.reload();
});
