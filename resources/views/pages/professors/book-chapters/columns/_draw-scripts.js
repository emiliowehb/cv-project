// Initialize KTMenu
KTMenu.init();

document.querySelectorAll('[data-kt-action="delete_chapter"]').forEach(function (element) {
    console.log('test');
    element.addEventListener('click', function () {
        Swal.fire({
            text: 'Are you sure you want to delete this chapter?',
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
                Livewire.dispatch('delete_chapter', [this.getAttribute('data-kt-chapter-id')]);
            }
        });
    });
});

// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="update_chapter"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.dispatch('update_chapter', [this.getAttribute('data-kt-chapter-id')]);
    });
});

// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the users-table datatable
    LaravelDataTables['professor-chapters-table'].ajax.reload();
});
