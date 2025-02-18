// Initialize KTMenu
KTMenu.init();

document.querySelectorAll('[data-kt-action="delete_paper"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Swal.fire({
            text: 'Are you sure you want to delete this paper?',
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
                Livewire.dispatch('delete_paper', [this.getAttribute('data-kt-paper-id')]);
            }
        });
    });
});

document.querySelectorAll('[data-kt-action="update_paper"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.dispatch('update_paper', [this.getAttribute('data-kt-paper-id')]);
    });
});

Livewire.on('success', (message) => {
    LaravelDataTables['professor-working-papers-table'].ajax.reload();
});
