<x-default-layout>

    @section('title')
    {{ __('messages.cv_builder') }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard.professors.cv-builder', $professor) }}
    @endsection


</x-default-layout>