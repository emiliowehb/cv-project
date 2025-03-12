document.addEventListener("DOMContentLoaded", function () {
    let page = 1;

    function fetchProfessors(reset = false) {
        let search = $('#search-bar').val();
        let researchAreas = $('#filter-research').val();
        let expertiseAreas = $('#filter-expertise').val();
        let country = $('#filter-country').val();
        let languages = $('#filter-languages').val();

        $.ajax({
            url: '/professors/directory',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                search: search,
                research_areas: researchAreas,
                expertise_areas: expertiseAreas,
                country: country,
                languages: languages,
                page: page
            },
            success: function (response) {
                if (reset) {
                    $('#professors-list').html(response.html);
                } else {
                    $('#professors-list').append(response.html);
                }

                if (response.hasMore) {
                    $('#load-more').removeClass('d-none');
                } else {
                    $('#load-more').addClass('d-none');
                }

                animateElements();
            }
        });
    }

    function animateElements() {
        $('#professors-list .professor-card').each(function (i) {
            // Slide up effect -24px to 12px
            $(this).delay(i * 100).animate({
                marginTop: 12,
                opacity: 1
            }, 300);
        });
    }

    $('#search-bar').on('change keyup', function () {
        page = 1;
        fetchProfessors(true);
    });

    $('.professors-directory-filters').on('select2:select', function () {
        page = 1;
        fetchProfessors(true);
    });

    $('.professors-directory-filters').on('select2:clear', function () {
        page = 1;
        fetchProfessors(true);
    });

    $('#load-more').on('click', function () {
        page++;
        fetchProfessors();
    });

    animateElements();
});