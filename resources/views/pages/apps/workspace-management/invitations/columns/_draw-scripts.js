// Initialize KTMenu
KTMenu.init();

document.querySelectorAll('[data-kt-action="revoke_invitation"]').forEach(function (element) {
    console.log('test');
    element.addEventListener('click', function () {
        Swal.fire({
            text: 'Are you sure you want to revoke this invitation?',
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
                Livewire.dispatch('revoke_invitation', [this.getAttribute('data-kt-invitation-id')]);
            }
        });
    });
});

// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the users-table datatable
    LaravelDataTables['workspace-invitations-table'].ajax.reload();
});
