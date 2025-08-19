@extends('layouts.app')
@section('title')
    Add New Employee
@endsection
@section('content')
    <x-page-title title="Employee" subtitle="Add New" />

    <div class="row">
        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="mb-4">Employee Information</h5>
                    
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ url('/employees') }}" method="POST" class="row g-3">
                        @csrf

                        <div class="col-md-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Employee Name" required>
                        </div>

                        <div class="col-md-12">
                            <label for="designation" class="form-label">Designation</label>
                            <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" required>
                        </div>

                        <div class="col-md-12">
                            <label for="branch_id" class="form-label">Branch</label>
                            <select class="form-select" id="branch_id" name="branch_id" required>
                                <option value="">Select Branch</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="basic_salary" class="form-label">Basic Salary</label>
                            <input type="text" class="form-control" id="basic_salary" name="basic_salary" placeholder="Basic Salary" required>
                        </div>

                        <div class="col-md-12">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" required>
                        </div>

                        <div class="col-md-12">
                            <label for="joining_date" class="form-label">Joining Date</label>
                            <input type="date" class="form-control" id="joining_date" name="joining_date" required>
                        </div>

                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button type="submit" class="btn btn-grd-primary px-4">Save Employee</button>
                                <button type="reset" class="btn btn-grd-royal px-4">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!--end row-->

@endsection
@push('script')
    <!--plugins-->
    <script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush