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

    function fetchPublications(search = '') {
        let publicationStatus = $('#filter-publication-status').val();
        let publicationType = $('#filter-publication-type').val();

        $.ajax({
            url: '/professors/publications-directory',
            method: 'GET',
            data: { 
                search,
                publication_status: publicationStatus,
                publication_type: publicationType
            },
            success: function (response) {
                $('#publications-list').html(response.html);
                animatePublications();
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

    function animatePublications() {
        $('#publications-list .publication-card').each(function (i) {
            $(this).delay(i * 100).animate({
                marginTop: 12,
                opacity: 1
            }, 300);
        });
    }

    $('#directoryTabs .nav-link').on('click', function (e) {
        e.preventDefault();
        $('#directoryTabs .nav-link').removeClass('active');
        $(this).addClass('active');

        $('.tab-content').addClass('d-none').removeClass('active');
        $('#' + $(this).data('tab')).removeClass('d-none').addClass('active');

        if ($(this).data('tab') === 'publications-tab') {
            fetchPublications();
        }
    });

    $('#search-bar').on('change keyup', function () {
        page = 1;
        fetchProfessors(true);
    });

    $('#search-bar').on('keyup', function () {
        let query = $(this).val().trim();
        if (query.length > 0) {
            $('#search-professors').text(`Search for "${query}" in Professors`);
            $('#search-publications').text(`Search for "${query}" in Publications`);
            $('#search-suggestions').show();
        } else {
            $('#search-suggestions').hide();
        }
    });

    $('#search-professors').on('click', function (e) {
        e.preventDefault();
        $('#directoryTabs .nav-link[data-tab="professors-tab"]').click();
        $('#search-suggestions').hide();
        fetchProfessors(true);
    });

    $('#search-publications').on('click', function (e) {
        e.preventDefault();
        $('#directoryTabs .nav-link[data-tab="publications-tab"]').click();
        $('#search-suggestions').hide();
        fetchPublications($('#search-bar').val().trim());
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('#search-bar, #search-suggestions').length) {
            $('#search-suggestions').hide();
        }
    });

    $('.professors-directory-filters').on('select2:select', function () {
        page = 1;
        fetchProfessors(true);
    });

    $('.professors-directory-filters').on('select2:clear', function () {
        page = 1;
        fetchProfessors(true);
    });

    $('.publications-directory-filters').on('select2:select select2:clear', function () {
        fetchPublications($('#search-bar').val().trim());
    });

    $('#load-more').on('click', function () {
        page++;
        fetchProfessors();
    });

    animateElements();
});