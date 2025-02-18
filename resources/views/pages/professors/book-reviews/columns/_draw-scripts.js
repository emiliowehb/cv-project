// Initialize KTMenu
KTMenu.init();

document.querySelectorAll('[data-kt-action="delete_review"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Swal.fire({
            text: 'Are you sure you want to delete this review?',
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
                Livewire.dispatch('delete_review', [this.getAttribute('data-kt-review-id')]);
            }
        });
    });
});

document.querySelectorAll('[data-kt-action="update_review"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.dispatch('update_review', [this.getAttribute('data-kt-review-id')]);
    });
});

Livewire.on('success', (message) => {
    LaravelDataTables['professor-book-reviews-table'].ajax.reload();
});
