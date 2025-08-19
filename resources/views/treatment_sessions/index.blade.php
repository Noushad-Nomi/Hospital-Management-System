@extends('layouts.app')

@section('title')
    Treatment Sessions
@endsection

@push('css')
    <link href="{{ URL::asset('build/plugins/input-tags/css/tagsinput.css') }}" rel="stylesheet">
@endpush

@section('content')
<x-page-title title="Treatment Sessions" subtitle="List of all treatment sessions" />

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('treatment-sessions.create') }}" class="btn btn-primary">Add New Session</a>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Session ID</th>
                            <th>Checkup ID</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Fee</th>
                            <th>Payment Details</th>
                            <th>Session Info</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sessions as $session)
                            <tr>
                                <td>{{ $session->id }}</td>
                                <td>{{ $session->checkup_id }}</td>
                                <td>{{ $session->patient->name ?? 'N/A' }}</td>
                                <td>{{ $session->checkup->doctor->name ?? 'N/A' }}</td>
                                <td>Rs. {{ number_format($session->session_fee, 0) }}</td>

                                {{-- Payment Details --}}
                                <td>
                                    <strong>Total Fee:</strong> Rs. {{ number_format($session->session_fee, 0) }}<br>
                                    <strong>Total Paid:</strong> Rs. {{ number_format($session->installments->sum('amount'), 0) }}<br>
                                    <strong>Dues:</strong> 
                                    <span class="{{ ($session->session_fee - $session->installments->sum('amount')) > 0 ? 'text-danger' : 'text-success' }}">
                                        Rs. {{ number_format($session->session_fee - $session->installments->sum('amount'), 0) }}
                                    </span>
                                    <br>
                                    <!-- Add Installment Button -->
                                    <button class="btn btn-sm btn-success mt-2" data-bs-toggle="modal" data-bs-target="#installmentModal{{ $session->id }}">
                                        + Add Installment
                                    </button>
                                </td>

                                {{-- Session Info --}}
                                <td>
                                    <strong>Total Sessions:</strong> {{ $session->sessionTimes->count() }}
                                    <br>
                                    <button class="btn btn-info btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#sessionModal{{ $session->id }}">
                                        View Details
                                    </button>
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('treatment-sessions.edit', $session->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('treatment-sessions.destroy', $session->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this session?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- Modal for Installment --}}
                            <div class="modal fade" id="installmentModal{{ $session->id }}" tabindex="-1" aria-labelledby="installmentModalLabel{{ $session->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('installments.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="session_id" value="{{ $session->id }}">
                                            
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="installmentModalLabel{{ $session->id }}">Add Installment (Session ID: {{ $session->id }})</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            
                                            <div class="modal-body">
                                                {{-- Display Validation Errors --}}
                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul class="mb-0">
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif

                                                <div class="mb-3">
                                                    <label for="amount" class="form-label">Amount</label>
                                                    <input type="number" class="form-control" name="amount" required
                                                           max="{{ $session->remainingAmount() }}"
                                                           placeholder="Remaining: {{ $session->remainingAmount() }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="payment_date" class="form-label">Paid On</label>
                                                    <input type="date" class="form-control" name="payment_date" required value="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>
                                            
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Installment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal for Session Info --}}
                            <div class="modal fade" id="sessionModal{{ $session->id }}" tabindex="-1" aria-labelledby="sessionModalLabel{{ $session->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="sessionModalLabel{{ $session->id }}">Session Details (ID: {{ $session->id }})</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            
                                            {{-- Completed Sessions --}}
                                            <h6 class="text-success">✅ Completed Sessions</h6>
                                            <ul>
                                                @forelse ($session->sessionTimes->where('is_completed', true) as $entry)
                                                    <li>
                                                        {{ \Carbon\Carbon::parse($entry->session_datetime)->format('d M Y - h:i A') }}
                                                        <br>
                                                        <small>
                                                            <strong>Doctor:</strong> {{ $entry->doctor->name ?? 'N/A' }} <br>
                                                            <strong>Work Done:</strong> {{ $entry->work_done ?? 'N/A' }}
                                                        </small>
                                                    </li>
                                                @empty
                                                    <li><em>No completed sessions yet</em></li>
                                                @endforelse
                                            </ul>

                                            {{-- Upcoming Sessions --}}
                                            <h6 class="text-primary mt-3">🕒 Upcoming Sessions</h6>
                                            <ul>
                                                @forelse ($session->sessionTimes->where('is_completed', false) as $entry)
                                                    <li>
                                                        {{ \Carbon\Carbon::parse($entry->session_datetime)->format('d M Y - h:i A') }}
                                                        <form action="{{ route('sessions.complete', $entry->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <select name="doctor_id" class="form-control form-control-sm d-inline w-auto" required>
                                                                @foreach($doctors as $doctor)
                                                                    <option value="{{ $doctor->id }}" {{ ($entry->completed_by_doctor_id ?? $session->checkup->doctor->id) == $doctor->id ? 'selected' : '' }}>
                                                                        {{ $doctor->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input type="text" name="work_done" placeholder="Session Description" class="form-control form-control-sm d-inline w-auto" value="{{ $entry->work_done ?? '' }}">
                                                            <button type="submit" class="btn btn-success btn-sm">✔ Complete</button>
                                                        </form>

                                                        <form action="{{ route('sessions.destroy', $entry->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this session?')">❌</button>
                                                        </form>
                                                    </li>
                                                @empty
                                                    <li><em>No upcoming sessions</em></li>
                                                @endforelse
                                            </ul>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
