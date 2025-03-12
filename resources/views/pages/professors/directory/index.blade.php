<x-default-layout>
    @section('title')
    Professors Directory
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard.professors.directory') }}
    @endsection

    <div class="container">
        <!-- Filters & Search Bar -->
        <div class="card p-4 mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <select id="filter-research" class="form-select professors-directory-filters" data-allow-clear="true" data-placeholder="Research Areas" data-control="select2" name="research">
                        <option></option>
                        @foreach($researchAreas as $researchArea)
                        <option value="{{ $researchArea->id }}">{{ $researchArea->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="filter-expertise" class="form-select professors-directory-filters" data-allow-clear="true" data-placeholder="Expertise Areas" data-control="select2" name="expertise">
                        <option></option>
                        @foreach($expertiseAreas as $expertiseArea)
                        <option value="{{ $expertiseArea->id }}">{{ $expertiseArea->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="filter-country" class="form-select professors-directory-filters" data-allow-clear="true" data-placeholder="Country" data-control="select2" name="country">
                        <option></option>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="filter-languages" class="form-select professors-directory-filters" data-allow-clear="true" data-placeholder="Languages" data-control="select2" name="languages">
                        <option></option>
                        @foreach($languages as $language)
                        <option value="{{ $language->id }}">{{ $language->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <input type="text" id="search-bar" class="form-control" placeholder="Search...">
                </div>
            </div>
        </div>
    
        <!-- Professors Grid -->
        <div id="professors-list" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @include('pages.professors.directory.partials.list')
        </div>
    
        <!-- Load More Button -->
        <div class="text-center mt-4">
            <button id="load-more" class="btn btn-primary d-none">Load More</button>
        </div>
    </div>
    <script src="{{ asset('js/professors-directory.js') }}"></script>
</x-default-layout>