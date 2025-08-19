@extends('layouts.app')
@section('title')
    Treatment Sessions
@endsection
@push('css')
    <link href="{{ URL::asset('build/plugins/input-tags/css/tagsinput.css') }}" rel="stylesheet">
@endpush
@section('content')
    <x-page-title title="Treatment Sessions" subtitle="Management" />

    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="mb-0">All Treatment Sessions</h5>
                        <div class="badge bg-primary p-2">
                            Total Sessions Scheduled: {{ $totalSessionTimes }}
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Checkup ID</th>
                                    <th>Patient Name</th>
                                    <th>Session Info</th>
                                    <th>Doctor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($treatmentSessions as $session)
                                <tr>
                                    <td>{{ $session->id }}</td>
                                    <td>{{ $session->checkup_id }}</td>
                                     <td>{{ $session->patient->name ?? 'N/A' }}</td>
                                    <td>
                                        @php $sessionCount = $session->sessionTimes->count(); @endphp
                                        <strong>Total: {{ $sessionCount }}</strong><br>
                                        @if($sessionCount > 0)
                                            <ul class="mb-0" style="padding-left: 15px;">
                                                @foreach($session->sessionTimes as $time)
                                                    <li>{{ \Carbon\Carbon::parse($time->session_datetime)->format('d M Y - H:i') }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <em>No sessions</em>
                                        @endif
                                    </td>
                                    <td>{{ $session->doctor->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($session->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($session->status === 'scheduled')
                                            <span class="badge bg-info">Scheduled</span>
                                        @elseif($session->status === 'missed')
                                            <span class="badge bg-danger">Missed</span>
                                        @else
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No sessions found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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