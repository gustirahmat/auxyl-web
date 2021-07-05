@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Daftar Karyawan
                    </h5>
                    <a href="{{ route('employee.create') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Karyawan
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.flash-message')
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Aksi</th>
                            <th>Jabatan</th>
                            <th>Nama Karyawan</th>
                            <th>Telp/WA</th>
                            <th>Alamat</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Group Button {{ $employee->employee_id }}">
                                        <a href="{{ route('employee.show', $employee->employee_id) }}">
                                            <button type="submit" class="btn btn-secondary mx-1">Detail</button>
                                        </a>
                                        <a href="{{ route('employee.edit', $employee->employee_id) }}">
                                            <button type="button" class="btn btn-secondary mx-1">Edit</button>
                                        </a>
                                    </div>
                                </td>
                                <td>{{ $employee->employee_position }}</td>
                                <td>{{ $employee->employee_name }}</td>
                                <td>{{ $employee->employee_phone }}</td>
                                <td>{{ $employee->employee_address }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Tidak ada data.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
