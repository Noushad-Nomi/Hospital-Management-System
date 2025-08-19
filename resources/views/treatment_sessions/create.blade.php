@extends('layouts.app')

@section('title')
    Treatment Session Form
@endsection

@push('css')
<link href="{{ URL::asset('build/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
<link href="{{ URL::asset('build/plugins/metismenu/metisMenu.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('build/plugins/simplebar/css/simplebar.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<x-page-title title="Treatment Session" subtitle="Form" />

<div class="row">
    <div class="col-xl-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('treatment-sessions.store') }}">
                    @csrf

                    @php 
                        $selectedCheckupId = old('checkup_id') ?? request()->get('checkup_id'); 
                        $selectedCheckup = $checkups->where('id', $selectedCheckupId)->first(); 
                        $selectedDoctorId = old('doctor_id') ?? ($selectedCheckup->doctor_id ?? null);
                    @endphp

                    <!-- Checkup -->
                    <div class="mb-3">
                        <label class="form-label">Checkup</label>
                        <select class="form-select" name="checkup_id" id="checkup_id" required>
                            <option value="">Select Checkup</option>
                            @foreach($checkups as $checkup)
                                <option value="{{ $checkup->id }}" 
                                    {{ $selectedCheckupId == $checkup->id ? 'selected' : '' }}>
                                    {{ $checkup->date }} - {{ $checkup->patient->name ?? 'No Patient' }}
                                    ({{ $checkup->doctor->name ?? 'No Doctor' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Patient Info -->
                    @if($selectedCheckup)
                        <div class="mb-3">
                            <label class="form-label">Patient</label>
                            <input type="text" class="form-control" value="{{ $selectedCheckup->patient->name ?? 'No Patient' }}" readonly>
                        </div>
                    @endif

                    <!-- Doctor -->
                    <div class="mb-3">
                        <label class="form-label">Doctor</label>
                        <select class="form-select" name="doctor_id" id="doctor_id" required>
                            <option value="">Select Doctor</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}"
                                    {{ $selectedDoctorId == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Total Fee -->
                    <div class="mb-3">
                        <label class="form-label">Total Session Fee</label>
                        <input type="number" class="form-control" name="session_fee" id="session_fee" value="{{ old('session_fee',0) }}" min="0" required>
                    </div>

                    <!-- Paid Amount -->
                    <div class="mb-3">
                        <label class="form-label">Paid Amount</label>
                        <input type="number" class="form-control" name="paid_amount" id="paid_amount" value="{{ old('paid_amount',0) }}" min="0" required>
                    </div>

                    <!-- Fee Summary -->
                    <div class="card mb-3">
                        <div class="card-body bg-light">
                            <h5 class="card-title">Fee Summary</h5>
                            <p>Total Fee: <strong id="totalFee">0</strong></p>
                            <p>Per Session Fee: <strong id="perSessionFee">0</strong></p>
                            <p>Paid Amount: <strong id="paidAmount">0</strong></p>
                            <p>Due Amount: <strong id="dueAmount">0</strong></p>
                        </div>
                    </div>

                    <!-- Sessions Table -->
                    <div class="mb-3">
                        <label class="form-label">Session Dates & Times</label>
                        <table id="sessionTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Session Date</th>
                                    <th>Session Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <p class="mt-2">Total Sessions: <span id="sessionCount">0</span></p>
                    </div>

                    <!-- Submit -->
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save Session</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>

<script>
let sessionIndex = 0;

function formatDate(date) {
    const d = new Date(date);
    return d.getFullYear() + '-' +
           String(d.getMonth()+1).padStart(2,'0') + '-' +
           String(d.getDate()).padStart(2,'0');
}

function addRow(button=null){
    let newDate = new Date();
    const rows = document.querySelectorAll('#sessionTable tbody tr');
    if(rows.length > 0){
        const lastDateInput = rows[rows.length-1].querySelector('input[type="date"]');
        const lastDate = new Date(lastDateInput.value);
        newDate = new Date(lastDate);
        newDate.setDate(newDate.getDate()+1);
    }

    const row = document.createElement('tr');
    row.innerHTML = `
        <td><input type="date" name="sessions[${sessionIndex}][date]" class="form-control" required value="${formatDate(newDate)}"></td>
        <td><input type="time" name="sessions[${sessionIndex}][time]" class="form-control" required value="12:00"></td>
        <td>
            <button type="button" class="btn btn-success btn-sm me-1" onclick="addRow(this)">➕</button>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">❌</button>
        </td>
    `;
    if(button){
        button.closest('tr').after(row);
    }else{
        document.querySelector('#sessionTable tbody').appendChild(row);
    }

    sessionIndex++;
    updateSessionCount();
    calculateFees();
}

function removeRow(button){
    button.closest('tr').remove();
    updateSessionCount();
    calculateFees();
}

function updateSessionCount(){
    const count = document.querySelectorAll('#sessionTable tbody tr').length;
    document.getElementById('sessionCount').innerText = count;
}

function calculateFees(){
    const sessionCount = document.querySelectorAll('#sessionTable tbody tr').length;
    const sessionFee = parseFloat(document.getElementById('session_fee').value) || 0;
    const paidAmount = parseFloat(document.getElementById('paid_amount').value) || 0;

    const perSession = sessionCount > 0 ? (sessionFee/sessionCount).toFixed(2) : 0;
    const due = (sessionFee - paidAmount).toFixed(2);

    document.getElementById('totalFee').innerText = sessionFee.toFixed(2);
    document.getElementById('perSessionFee').innerText = perSession;
    document.getElementById('paidAmount').innerText = paidAmount.toFixed(2);
    document.getElementById('dueAmount').innerText = due;
}

document.addEventListener('DOMContentLoaded', function(){
    addRow(); // default first row
    document.getElementById('session_fee').addEventListener('input', calculateFees);
    document.getElementById('paid_amount').addEventListener('input', calculateFees);

    // Change doctor when checkup changes
    document.getElementById('checkup_id').addEventListener('change', function(){
        const selectedCheckupId = this.value;
        const checkup = @json($checkups->keyBy('id'));
        if(checkup[selectedCheckupId]){
            const doctorId = checkup[selectedCheckupId].doctor_id;
            document.getElementById('doctor_id').value = doctorId ?? '';
        }
    });
});
</script>
@endpush
