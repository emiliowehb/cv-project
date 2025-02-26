<style>
    .preview-container {
        border: 3px solid #e5e5e5;
        padding: 15px;
    }

    .card-no-radius {
        border-radius: 0;
    }

    .disabled {
        opacity: 0.5;
        pointer-events: none;
    }

    .table-bordered {
        border: 2px solid #dee2e6;
        width: 100%;
        border-collapse: collapse;
    }

    .table-bordered th,
    .table-bordered td {
        border: 2px solid #dee2e6;
        padding: 8px;
        text-align: left;
    }

    .card-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .card-subtitle {
        font-size: 18px;
        color: #6c757d;
    }

    .fs-1 {
        font-size: 2rem;
    }

    .fs-3 {
        font-size: 1.75rem;
    }

    .fs-4 {
        font-size: 1.5rem;
    }

    .fs-5 {
        font-size: 1rem;
    }

    .mt-2 {
        margin-top: 0.5rem;
    }

    .mt-15 {
        margin-top: 15px;
    }

    .mb-5 {
        margin-bottom: 20px;
    }
</style>

<div class="preview-container mt-15">
    <div class="card card-no-radius">
        <div class="card-body">
            <h5 class="card-title fs-1 mb-5">LOGO HERE</h5>
            <h6 class="card-subtitle text-muted fs-4">CURRICULUM VITAE</h6>
            <h6 class="mt-2 fs-5">{{Carbon\Carbon::now()->format('d/m/Y')}}</h6>

            <!-- Begin Professor name and address -->
            <div class="mt-15">
                <h5 class="fs-3">{{ $professor->fullName() }}</h5>
                <p>{{$professor->formattedAddress()}}</p>
            </div>
            <!-- End professor name and address -->

            <!-- Begin Degrees Section -->
            <div class="mt-15" id="professor-degrees">
                <div class="d-flex align-items-center">
                    <h3>DEGREES</h3>
                </div>
            </div>
            <div id="degrees-content">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Degree</th>
                            <th>Institution</th>
                            <th>Discipline</th>
                            <th>Year</th>
                        </tr>
                    </thead>
                    <tbody id="degrees-table-body">
                        @foreach($professor->degrees as $degree)
                        <tr data-year="{{ $degree->year }}">
                            <td>{{ $degree->degree->name }}</td>
                            <td>{{ $degree->institution_name }}</td>
                            <td>{{ $degree->discipline->name }}</td>
                            <td>{{ $degree->year }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>