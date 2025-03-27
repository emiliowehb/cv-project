<x-default-layout>
    @section('title')
    {{ __('messages.reports_generator') }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard.reports-generator') }}
    @endsection

    <form action="{{ route('reports-generator.submit') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('messages.reports_generator') }}</h3>
            </div>
            <div class="card-body">
                <!-- Begin Options -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="report_type" class="form-label">{{ __('messages.report_type') }}</label>
                        <select id="report_type" name="report_type" class="form-select">
                            @foreach($report_types as $report_type)
                            <option value="{{ $report_type['id'] }}">{{ __('messages.' . $report_type['value']) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="format" class="form-label">{{ __('messages.format') }}</label>
                        <select id="format" name="format" class="form-select">
                            @foreach($formats as $format)
                            <option value="{{ $format }}">{{ __('messages.' . $format) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- End Options -->
                <!-- Begin Submit Button -->
                <div class="text-end pt-15">
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">{{ __('messages.create') }}</span>
                        <span class="indicator-progress" style="display: none;">
                            {{ __('messages.please_wait') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
                <!-- End Submit Button -->
            </div>
        </div>
    </form>
</x-default-layout>