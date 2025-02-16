// Add any custom draw callback scripts here
// Initialize KTMenu
KTMenu.init();

document.querySelectorAll('[data-kt-action="delete_re"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Swal.fire({
            text: 'Are you sure you want to delete this interest?',
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
                Livewire.dispatch('delete_re', [this.getAttribute('data-kt-re-id')]);
            }
        });
    });
});

// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="update_re"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.dispatch('update_re', [this.getAttribute('data-kt-re-id')]);
    });
});

// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the users-table datatable
    LaravelDataTables['professor-research-interest-table'].ajax.reload();
});
