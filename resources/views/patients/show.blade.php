@extends('layouts.app')
@section('title')
    Patient Details
@endsection
@push('css')
    <link href="{{ URL::asset('build/plugins/input-tags/css/tagsinput.css') }}" rel="stylesheet">

    <style>
        @media print {
            /* Print ke waqt sirf patient card dikhai de, baaki sab chhupa dein */
            body * {
                visibility: hidden;
            }
            .card.rounded-4, .card.rounded-4 * {
                visibility: visible;
            }
            .card.rounded-4 {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            /* Print button bhi chhupana hai */
            .print-button {
                display: none !important;
            }
        }
    </style>
@endpush
@section('content')
    <x-page-title title="Patient" subtitle="Details" />

    <div class="row">
        <div class="col-xl-8">
            <!-- Patient Profile Card -->
            <div class="card rounded-4">
                <div class="row g-0 align-items-center">
                    <div class="col-md-3 text-center border-end">
                        <div class="p-4">
                            <div class="bg-light rounded-circle shadow d-inline-block p-3 mb-3">
                                <i class="material-icons-outlined" style="font-size: 4rem;">person</i>
                            </div>
                            <h4 class="mt-3 mb-0">{{ $patient->name ?? 'N/A' }}</h4>
                            <p class="text-muted">Patient ID: {{ $patient->id ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-1">Father/Husband Name</h6>
                                        <p class="h5">{{ $patient->guardian_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-1">Age</h6>
                                        <p class="h5">
                                            {{ $patient->age ? $patient->age . ' years' : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-1">Phone</h6>
                                        <p class="h5">{{ $patient->phone ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-1">Branch</h6>
                                        <p class="h5">{{ $patient->branch->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-1">Registered On</h6>
                                        <p class="h5">{{ $patient->created_at->format('d M Y') ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->

    <div class="mt-3 text-end print-button">
        <button class="btn btn-primary" onclick="window.print();">
            <i class="material-icons-outlined">print</i> Print
        </button>
    </div>
@endsection

@push('script')
    <!--plugins-->
    <script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/input-tags/js/tagsinput.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush
