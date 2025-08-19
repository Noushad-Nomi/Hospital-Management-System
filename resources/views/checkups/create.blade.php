@extends('layouts.app')

@section('title')
    Add Checkup
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" 
          href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
@endpush

@section('content')
    <x-page-title title="Checkup" subtitle="Add New Checkup" />

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ url('/checkups') }}" class="row g-3">
                        @csrf

                        <!-- Patient Dropdown with Select2 Search -->
                        <div class="col-md-12">
                            <label for="patient_id" class="form-label">Patient</label>
                            <select name="patient_id" id="patient_id" class="form-select" required>
                                <option value="">Select Patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">
                                        {{ $patient->id }} - {{ $patient->name }} - {{ $patient->phone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date -->
                        <div class="col-md-12">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date" class="form-control"
                                value="{{ old('date', date('Y-m-d')) }}" required>
                        </div>

                        <!-- Diagnosis -->
                        <div class="col-md-12">
                            <label for="diagnosis" class="form-label">Diagnosis</label>
                            <input type="text" name="diagnosis" id="diagnosis" class="form-control" required>
                        </div>

                        <!-- Note -->
                        <div class="col-md-12">
                            <label for="note" class="form-label">Note</label>
                            <input type="text" name="note" id="note" class="form-control" placeholder="Doctor can write notes here">
                        </div>

                        <!-- Doctor Dropdown with Select2 -->
                        <div class="col-md-12">
                            <label for="doctor_id" class="form-label">Doctor</label>
                            <select name="doctor_id" id="doctor_id" class="form-select" required>
                                <option value="">Select Doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fee -->
                        <div class="col-md-12">
                            <label for="fee" class="form-label">Checkup Fee</label>
                            <input type="number" name="fee" id="fee" class="form-control" value="{{ $defaultFee }}" readonly>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button type="submit" class="btn btn-primary px-4">Add Checkup</button>
                                <button type="reset" class="btn btn-secondary px-4">Reset</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<!-- jQuery CDN (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        function matchCustom(params, data) {
            if ($.trim(params.term) === '') {
                return data;
            }

            var term = params.term.toLowerCase();
            var text = data.text.toLowerCase();
            var id = data.id ? data.id.toString().toLowerCase() : '';

            if (text.startsWith(term) || id.startsWith(term)) {
                return data;
            }

            if (text.indexOf(term) > -1 || id.indexOf(term) > -1) {
                return data;
            }

            return null;
        }

        $('#patient_id').select2({
            placeholder: "Search patient by ID, name or phone...",
            theme: 'bootstrap-5',
            width: '100%',
            matcher: matchCustom,
            allowClear: true
        });

        $('#doctor_id').select2({
            placeholder: "Select doctor...",
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true
        });
    });
</script>

<!-- Other JS Plugins -->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush
