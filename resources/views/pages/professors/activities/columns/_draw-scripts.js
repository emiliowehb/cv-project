// Initialize KTMenu
KTMenu.init();

document.querySelectorAll('[data-kt-action="delete_activity"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Swal.fire({
            text: 'Are you sure you want to delete this activity?',
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
                Livewire.dispatch('delete_activity', [this.getAttribute('data-kt-activity-id')]);
            }
        });
    });
});

document.querySelectorAll('[data-kt-action="update_activity"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.dispatch('update_activity', [this.getAttribute('data-kt-activity-id')]);
    });
});

Livewire.on('success', (message) => {
    LaravelDataTables['professor-activity-table'].ajax.reload();
});
