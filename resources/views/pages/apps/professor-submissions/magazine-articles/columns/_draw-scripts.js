// Initialize KTMenu
KTMenu.init();

// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the users-table datatable
    LaravelDataTables['magazine-article-reviewables-table'].ajax.reload();
});


// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="approveReviewable"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.dispatch('approveReviewable', [this.getAttribute('data-reviewable-id')]);
    });
});

document.querySelectorAll('[data-kt-action="denyReviewable"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.dispatch('denyReviewable', [this.getAttribute('data-reviewable-id')]);
    });
});
