@php
    $hasAuthors = !empty($selectedAuthors) && count($selectedAuthors) > 0;
@endphp

<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $title }}</h3>
    </div>
    <div class="card-body">
        <div id="authorRepeater">
            <div class="form-group">
                <div data-repeater-list="authors" class="sortable">
                    @if($hasAuthors)
                        @foreach($selectedAuthors as $author)
                            <div data-repeater-item class="d-flex align-items-center mb-3 gap-2">
                                <div class="drag-handle cursor-move">
                                    <i class="bi bi-arrows-move"></i>
                                </div>
                                <select class="form-select author-select" data-kt-repeater="select2" data-control="select2" data-placeholder="Select an author" name="author_id">
                                    <option></option>
                                    @foreach ($authors as $a)
                                        <option value="{{ $a->id }}" {{ $a->id == $author->id ? 'selected' : '' }}>{{ $a->name }}</option>
                                    @endforeach
                                </select>
                                <button data-repeater-delete type="button" class="btn btn-danger btn-sm ms-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div data-repeater-item class="d-flex align-items-center mb-3 gap-2">
                            <div class="drag-handle cursor-move">
                                <i class="bi bi-arrows-move"></i>
                            </div>
                            <select class="form-select author-select" data-kt-repeater="select2" data-control="select2" data-placeholder="Select an author" name="author_id">
                                <option></option>
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                                @endforeach
                            </select>
                            <button data-repeater-delete type="button" class="btn btn-danger btn-sm ms-2">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Add row button -->
            <button data-repeater-create disable type="button" class="btn btn-primary mt-3" id="addAuthor">
                <i class="fas fa-plus"></i> Add Author
            </button>
        </div>
        <div class="mt-4">
            <h5>Add a New Author</h5>
            <div class="input-group">
                <input type="text" id="newFirstName" class="form-control" placeholder="First Name">
                <input type="text" id="newLastName" class="form-control" placeholder="Last Name">
                <button type="button" id="addNewAuthor" class="btn btn-success">Add</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js" defer></script>
<script src="{{ asset('js/author-repeater.js') }}"></script>