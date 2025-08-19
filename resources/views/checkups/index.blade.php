@extends('layouts.app')

@section('title')
    Patient Checkups
@endsection

@section('content')

    <x-page-title title="Patient Records" subtitle="Checkups List" />
    
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <div class="mb-3">
                        <a href="{{ url('/checkups/create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Checkup
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Patient</th>
                                    <th>Date</th>
                                    <th>Diagnosis</th>
                                    <th>Doctor</th>
                                    <th>Fee</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($checkups as $checkup)
                                    <tr>
                                        <td>{{ $checkup->patient_name ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($checkup->date)->format('d-m-Y') }}</td>
                                       {{-- <td>{{ $checkup->phone ?? 'N/A' }}</td>--}}
                                        <td>{{ $checkup->diagnosis }}</td>
                                        <td>{{ $checkup->doctor_name }}</td>
                                        <td>Rs. {{ $checkup->fee }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ url('/checkups/' . $checkup->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{ url('/checkups/' . $checkup->id . '/edit') }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>

                                            


                                                <a href="{{ route('checkups.print', $checkup->id) }}" class="btn btn-sm btn-secondary">
                                               <i class="fas fa-print"></i> Print
                                               </a>

                                         <a href="{{ route('treatment-sessions.create', ['checkup_id' => $checkup->id]) }}" 
   class="btn btn-sm btn-secondary">
   <i class="fas fa-layer-group"></i> Sessions
</a>








                                                <form method="POST" action="{{ url('/checkups/' . $checkup->id) }}" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" type="submit">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
@endsection

@push('script')
    <!--plugins-->
    <script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/main.js') }}"></script>
    
    <!-- Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
@endpush
