// Initialize KTMenu
KTMenu.init();

document.querySelectorAll('[data-kt-action="delete_presentation"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Swal.fire({
            text: 'Are you sure you want to delete this presentation?',
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
                Livewire.dispatch('delete_presentation', [this.getAttribute('data-kt-presentation-id')]);
            }
        });
    });
});

// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="update_presentation"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.dispatch('update_presentation', [this.getAttribute('data-kt-presentation-id')]);
    });
});

// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the presentations-table datatable
    LaravelDataTables['professor-presentations-table'].ajax.reload();
});
