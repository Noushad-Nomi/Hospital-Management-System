@extends('layouts.app')
@section('title')
    Checkup Details
@endsection
@push('css')
    <link href="{{ URL::asset('build/plugins/input-tags/css/tagsinput.css') }}" rel="stylesheet">
@endpush
@section('content')
    <x-page-title title="Checkup" subtitle="Details" />

    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <!-- Patient Name -->
                    <div class="mb-3">
                        <label class="form-label"><strong>Patient:</strong></label>
                        <input type="text" class="form-control" value="{{ $checkup->patient_name }}" readonly>
                    </div>

                    <!-- Date -->
                    <div class="mb-3">
                        <label class="form-label"><strong>Date:</strong></label>
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($checkup->date)->format('d-m-Y') }}" readonly>
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label class="form-label"><strong>Phone:</strong></label>
                        <input type="text" class="form-control" value="{{ $checkup->patient_phone }}" readonly>
                    </div>

                    <!-- Diagnosis -->
                    <div class="mb-3">
                        <label class="form-label"><strong>Diagnosis:</strong></label>
                        <textarea class="form-control" rows="3" readonly>{{ $checkup->diagnosis }}</textarea>
                    </div>

                    <!-- Note -->
                    <div class="mb-3">
                        <label class="form-label"><strong>Note:</strong></label>
                        <textarea class="form-control" rows="3" readonly>{{ $checkup->note ?? 'N/A' }}</textarea>
                    </div>

                    <!-- Doctor -->
                    <div class="mb-3">
                        <label class="form-label"><strong>Doctor:</strong></label>
                        <input type="text" class="form-control" value="{{ $checkup->doctor_name ?? 'N/A' }}" readonly>
                    </div>

                    <a href="/checkups" class="btn btn-secondary mt-3">Back to List</a>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
@endsection

@push('script')
    <!--plugins-->
    <script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/input-tags/js/tagsinput.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush
