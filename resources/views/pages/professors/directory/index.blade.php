<x-default-layout>
    @section('title')
    Directory
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard.professors.directory') }}
    @endsection

    <div class="col-md-12 mb-5 position-relative">
        <input type="text" id="search-bar" class="form-control" placeholder="Search...">
        <div id="search-suggestions" class="list-group position-absolute w-100 shadow-sm" style="z-index: 1000; display: none;">
            <a href="#" id="search-professors" class="list-group-item list-group-item-action"></a>
            <a href="#" id="search-publications" class="list-group-item list-group-item-action"></a>
        </div>
    </div>
    <div class="container">
        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4" id="directoryTabs">
            <li class="nav-item">
                <a class="nav-link active" data-tab="professors-tab" href="#">Professors</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-tab="publications-tab" href="#">Publications</a>
            </li>
        </ul>

        <!-- Professors Tab Content -->
        <div id="professors-tab" class="tab-content active">
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

        <!-- Publications Tab Content -->
        <div id="publications-tab" class="tab-content d-none">
            <!-- Filters -->
            <div class="card p-4 mb-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <select id="filter-publication-status" class="form-select publications-directory-filters" data-allow-clear="true" data-placeholder="Publication Status" data-control="select2">
                            <option></option>
                            @foreach(\App\Models\PublicationStatus::all() as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select id="filter-publication-type" class="form-select publications-directory-filters" data-allow-clear="true" data-placeholder="Publication Type" data-control="select2">
                            <option></option>
                            <option value="journal">Journal</option>
                            @foreach(\App\Models\ArticleType::all() as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div id="publications-list" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <!-- Publications will be loaded via AJAX -->
            </div>
        </div>
    </div>

    <script src="{{ asset('js/professors-directory.js') }}"></script>
</x-default-layout>