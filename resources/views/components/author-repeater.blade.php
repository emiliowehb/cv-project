@php
    $hasAuthors = !empty($selectedAuthors) && count($selectedAuthors) > 0;
@endphp

<!-- Button to open modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#authorModal">
    <i class="fas fa-user-plus"></i> 
    {{ $hasAuthors ? 'Edit Associated Authors' : 'Select Authors' }}
</button>

<!-- Modal -->
<div class="modal fade" id="authorModal" tabindex="-1" aria-labelledby="authorModalLabel" aria-hidden="true" role="dialog" wire:ignore.self>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="authorModalLabel">Manage Authors for {{ $class }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Metronic Form Repeater -->
                <form id="authorRepeaterForm">
                    <div id="authorRepeater">
                        <div class="form-group">
                            <div data-repeater-list="authors">
                                @if($hasAuthors)
                                    @foreach($selectedAuthors as $author)
                                        <div data-repeater-item class="d-flex align-items-center mb-3">
                                            <select class="form-select" data-kt-repeater="select2" data-control="select2" data-placeholder="Select an author" data-dropdown-parent="#authorModal" name="author_id">
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
                                    <!-- Template row -->
                                    <div data-repeater-item class="d-flex align-items-center mb-3">
                                        <select class="form-select" data-kt-repeater="select2" data-control="select2" data-placeholder="Select an author" data-dropdown-parent="#authorModal" name="author_id">
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
                        <button data-repeater-create type="button" class="btn btn-primary mt-3">
                            <i class="fas fa-plus"></i> Add Author
                        </button>
                    </div>
                </form>

                <!-- Add New Author -->
                <div class="mt-4">
                    <h5>Add a New Author</h5>
                    <div class="input-group">
                        <input type="text" id="newFirstName" class="form-control" placeholder="First Name">
                        <input type="text" id="newLastName" class="form-control" placeholder="Last Name">
                        <button type="button" id="addNewAuthor" class="btn btn-success">Add</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="saveAuthors">Save Authors</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/author-repeater.js') }}"></script>