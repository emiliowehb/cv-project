// Initialize KTMenu
KTMenu.init();

document.querySelectorAll('[data-kt-action="delete_book"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Swal.fire({
            text: 'Are you sure you want to delete this book?',
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
                Livewire.dispatch('delete_book', [this.getAttribute('data-kt-book-id')]);
            }
        });
    });
});

document.querySelectorAll('[data-kt-action="update_book"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.dispatch('update_book', [this.getAttribute('data-kt-book-id')]);
    });
});

Livewire.on('success', (message) => {
    LaravelDataTables['professor-books-table'].ajax.reload();
});
