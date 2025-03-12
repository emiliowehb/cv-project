document.addEventListener("DOMContentLoaded", function () {
    function toggleAddButton() {
        const lastSelect = document.querySelector('[data-repeater-item]:last-child .author-select');

        if (!lastSelect) {
            $('#addAuthor').prop("disabled", false);
            return;
        }

        if (lastSelect && lastSelect.value) {
            $('#addAuthor').prop("disabled", false);
        } else {
            $('#addAuthor').prop("disabled", true);
        }
    }

    function updateAvailableAuthors() {
        const selectedAuthors = Array.from(document.querySelectorAll('select.author-select'))
            .map(select => select.value)
            .filter(id => id);

        $('select.author-select').each(function () {
            const select = $(this);
            const currentValue = select.val();
            select.find("option").each(function () {
                const option = $(this);
                if (selectedAuthors.includes(option.val()) && option.val() !== currentValue) {
                    option.prop("disabled", true);
                } else {
                    option.prop("disabled", false);
                }
            });
        });

        $(this).find('[data-kt-repeater="select2"]').select2()
    }

    function getLastSelectOptions(selectedId) {
        const lastSelect = $('select.author-select').last();
        let options = lastSelect.length ? lastSelect.html() : '<option value="">Select an author</option>';
        options = options.replace(`value="${selectedId}"`, `value="${selectedId}" selected`);

        return options;
    }

    // Repeater initialization
    if($('#authorRepeater').length){
        $('#authorRepeater').repeater({
            initEmpty: false,
            show: function () {
                $(this).slideDown();
                $(this).find('[data-kt-repeater="select2"]').select2()
                .on("select2:select", function () {
                    toggleAddButton();
                });
                toggleAddButton();
                updateAvailableAuthors();
            },
            hide: function (deleteElement) {
                // $(this).slideUp(deleteElement);
                $(this).slideUp(() => {
                    deleteElement();
                    toggleAddButton();
                    updateAvailableAuthors();
                });
            },
            ready: function () {
                $('[data-kt-repeater="select2"]').select2()
                .on("select2:select", function () {
                    toggleAddButton();
                    updateAvailableAuthors();
                });
            }
        });
    }

    // Add new author dynamically
    $(document).on("click", '#addNewAuthor', function () {
        const firstName = $("#newFirstName").val().trim();
        const lastName = $("#newLastName").val().trim();

        if (firstName && lastName) {
            // TODO: Add loading spinner
            $.ajax({
                url: "/authors",
                type: "POST",
                data: {
                    first_name: firstName,
                    last_name: lastName,
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function (response) {
                    let newOption = new Option(response.name, response.id, false, false);
                    $('.author-select').each(function () {
                        $(this).append(newOption.cloneNode(true));
                    }).trigger('change.select2');

                    $("#newFirstName").val("");
                    $("#newLastName").val("");

                    // Append new author to the repeater
                    $('#authorRepeater').find('[data-repeater-list]').append(
                        '<div data-repeater-item class="d-flex align-items-center mb-3 gap-2">' +
                        '<div class="drag-handle cursor-move">' +
                        '<i class="bi bi-arrows-move"></i>' +
                        '</div>' +
                        '<select class="form-select author-select" data-kt-repeater="select2" data-control="select2" data-placeholder="Select an author" name="author_id">' +
                        getLastSelectOptions(response.id)
                        +
                        '</select>' +
                        '<button data-repeater-delete type="button" class="btn btn-danger btn-sm ms-2">' +
                        '<i class="fas fa-trash"></i>' +
                        '</button>' +
                        '</div>'
                    );

                    updateAvailableAuthors();

                    // Enable Select2 on the new element
                    $('#authorRepeater').find('[data-kt-repeater="select2"]').select2();
                },
                error: function () {
                    Swal.fire("Error", "Failed to add author.", "error");
                }
            });
        } else {
            Swal.fire("Warning", "Please enter both first and last name.", "warning");
        }
    });

    // Initialisation
    toggleAddButton();

    // Sortable
    if($( ".sortable" ).length)
    {
        $( ".sortable" ).sortable({ handle: '.drag-handle' });
    }

});