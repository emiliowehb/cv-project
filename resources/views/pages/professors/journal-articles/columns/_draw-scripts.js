// Initialize KTMenu
KTMenu.init();

document.querySelectorAll('[data-kt-action="delete_jarticle"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Swal.fire({
            text: 'Are you sure you want to delete this article?',
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
                Livewire.dispatch('delete_jarticle', [this.getAttribute('data-kt-jarticle-id')]);
            }
        });
    });
});

document.querySelectorAll('[data-kt-action="update_jarticle"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.dispatch('update_jarticle', [this.getAttribute('data-kt-jarticle-id')]);
    });
});

Livewire.on('success', (message) => {
    LaravelDataTables['professor-journal-articles-table'].ajax.reload();
});
