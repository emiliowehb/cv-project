// Add any custom draw callback scripts here
// Initialize KTMenu
KTMenu.init();

document.querySelectorAll('[data-kt-action="delete_report"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Swal.fire({
            text: 'Are you sure you want to delete this report?',
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
                Livewire.dispatch('delete_report', [this.getAttribute('data-kt-report-id')]);
            }
        });
    });
});

// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="update_report"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.dispatch('update_report', [this.getAttribute('data-kt-report-id')]);
    });
});

// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the users-table datatable
    LaravelDataTables['professor-technical-report-table'].ajax.reload();
});
