@extends('layouts.app')
@section('title')
    Employee Datatable
@endsection
@push('css')
    <link href="{{ URL::asset('build/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <x-page-title title="Employees" subtitle="Employee Data Table" />

    <div class="d-flex justify-content-end mb-3">
        <a href="/employees/create" class="btn btn-primary">+ Add New Employee</a>
    </div>

    <h6 class="mb-0 text-uppercase">Employee DataTable</h6>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Branch</th>
                            <th>Basic Salary</th>
                            <th>Phone</th>
                            <th>Joining Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $index => $employee)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->designation }}</td>
                            <td>{{ $employee->branch_id }}</td>
                            <td>{{ $employee->basic_salary }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>{{ $employee->joining_date }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Branch</th>
                            <th>Basic Salary</th>
                            <th>Phone</th>
                            <th>Joining Date</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <!--plugins-->
    <script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
    <script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush