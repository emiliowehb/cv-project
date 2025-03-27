<style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        color: #333;
    }

    .preview-container {
        border: 3px solid #e5e5e5;
        padding: 15px;
        margin-bottom: 20px;
    }

    .card-no-radius {
        border-radius: 0;
    }

    .table-bordered {
        border: 2px solid #dee2e6;
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
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

    .fs-1 { font-size: 2rem; }
    .fs-4 { font-size: 1.5rem; }
    .fs-5 { font-size: 1rem; }

    .mt-2 { margin-top: 0.5rem; }
    .mt-15 { margin-top: 15px; }
    .mb-5 { margin-bottom: 20px; }

    h3 {
        font-size: 1.5rem;
        color: #007bff;
        margin-bottom: 10px;
    }

    .signature {
        text-align: center;
        margin-top: 30px;
    }
</style>

<div class="preview-container mt-15">
    <div class="card card-no-radius">
        <div class="card-body">
            <h5 class="card-title fs-1 mb-5">LOGO HERE</h5>
            <h6 class="card-subtitle text-muted fs-4">Subjects Report</h6>

            <!-- Begin Subjects Report Table -->
            <div class="mt-15" id="subjects-table">
                <div class="d-flex align-items-center">
                    <h3>Subjects</h3>
                </div>
                <div id="subjects-content">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Subject</th>
                            </tr>
                        </thead>
                        <tbody id="subjects-table-body">
                            @foreach($data as $course)
                            <tr data-type="subject">
                                <td>{{ $course->courseTopic->subject->name ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Subjects Report Table -->
        </div>
        <div class="card-footer">
            <div class="signature mt-15">
                <h6 class="mt-2 fs-5">Generated on: {{Carbon\Carbon::now()->format('d/m/Y')}}</h6>
            </div>
        </div>
    </div>
</div>
