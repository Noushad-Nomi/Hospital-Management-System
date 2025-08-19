@extends('layouts.app')
@section('title')
    Payments Outstanding
@endsection
@section('content')

    <x-page-title title="Payments" subtitle="Outstanding Payments" />

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <table class="table mb-0 table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Session ID</th>
                                <th scope="col">Checkup ID</th>
                                <th scope="col">Patient Name</th>
                                <th scope="col">Payment Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($outstandings as $session)
                                <tr>
                                    <td>{{ $session->id }}</td>
                                    <td>{{ $session->checkup_id }}</td>
                                    <td>{{ $session->patient->name ?? 'N/A' }}</td>
                                    <td>
                                        Total Fee: {{ $session->session_fee }} <br>
                                        Paid: {{ $session->totalPaid() }} <br>
                                        Due: {{ $session->remainingAmount() }} <br><br>

                                        @if($session->installments && $session->installments->count())
                                            <strong>Installments:</strong><br>
                                            <ul style="margin: 0; padding-left: 16px;">
                                                @foreach($session->installments as $installment)
                                                    <li>
                                                        {{ number_format($installment->amount, 2) }} on {{ \Carbon\Carbon::parse($installment->date)->format('d M Y') }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <em>No installments</em>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align:center;">No outstanding payments found.</td>
                                </tr>
                            @endforelse
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
    <script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush