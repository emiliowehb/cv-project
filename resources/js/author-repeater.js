document.addEventListener("DOMContentLoaded", function () {
    let formRepeater = $("#authorRepeater").repeater({
        initEmpty: false,
        show: function () {
            $(this).slideDown();
            $(this).find('[data-kt-repeater="select2"]').select2();
        },
        hide: function (deleteElement) {
            Swal.fire({
                title: "Are you sure?",
                text: "This author will be removed.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).slideUp(deleteElement);
                }
            });
        },
        ready: function(){
            $('[data-kt-repeater="select2"]').select2();
        }
    });

    // Add new author dynamically
    $("#addNewAuthor").on("click", function () {
        let firstName = $("#newFirstName").val().trim();
        let lastName = $("#newLastName").val().trim();

        if (firstName && lastName) {
            $.ajax({
                url: "/authors",
                type: "POST",
                data: {
                    first_name: firstName,
                    last_name: lastName,
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function (response) {
                    let newOption = new Option(response.full_name, response.id, true, true);
                    $("select[name='author_id']").append(newOption).trigger("change");
                    $("#newFirstName").val("");
                    $("#newLastName").val("");

                    // Append new author to the repeater
                    formRepeater.find('[data-repeater-list]').append(
                        '<div data-repeater-item class="d-flex align-items-center mb-3">' +
                            '<select class="form-select" data-kt-repeater="select2" data-control="select2" data-placeholder="Select an author" data-dropdown-parent="#authorModal" name="author_id">' +
                                '<option value="' + response.id + '">' + response.name + '</option>' +
                            '</select>' +
                            '<button data-repeater-delete type="button" class="btn btn-danger btn-sm ms-2">' +
                                '<i class="fas fa-trash"></i>' +
                            '</button>' +
                        '</div>'
                    );

                    // Enable Select2 on the new element
                    formRepeater.find('[data-kt-repeater="select2"]').select2();

                    Swal.fire({
                        title: "Success!",
                        text: "Author added successfully.",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function () {
                    Swal.fire("Error", "Failed to add author.", "error");
                }
            });
        } else {
            Swal.fire("Warning", "Please enter both first and last name.", "warning");
        }
    });

    // Save selected authors
    $("#saveAuthors").on("click", function () {
        let selectedAuthors = [];

        $("select[name='author_id']").each(function () {
            let authorId = $(this).val();
            if (authorId) {
                selectedAuthors.push(authorId);
            }
        });
        
        $("#authorModal").modal("hide");

        Swal.fire({
            title: "Saved!",
            text: "Authors have been successfully saved.",
            icon: "success",
            timer: 2000,
            showConfirmButton: false
        });
    });

    // Enable Drag & Drop
    // $("#authorRepeater [data-repeater-list]").sortable();
});