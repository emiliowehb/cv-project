// Initialize KTMenu
KTMenu.init();

document.querySelectorAll('[data-kt-action="delete_article"]').forEach(function (element) {
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
                Livewire.dispatch('delete_article', [this.getAttribute('data-kt-article-id')]);
            }
        });
    });
});

document.querySelectorAll('[data-kt-action="update_article"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.dispatch('update_article', [this.getAttribute('data-kt-article-id')]);
    });
});

Livewire.on('success', (message) => {
    LaravelDataTables['professor-articles-table'].ajax.reload();
});
