@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Detail Karyawan
                    </h5>
                    <a href="{{ route('employee.edit', $employee->employee_id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil-square"></i>
                        Edit Karyawan
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.flash-message')
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-borderless">
                        <tr>
                            <td>Nama Karyawan</td>
                            <td>:</td>
                            <th>{{ $employee->employee_name }}</th>
                        </tr>
                        <tr>
                            <td>No. Telp. / WhatsApp (WA)</td>
                            <td>:</td>
                            <th>{{ $employee->employee_phone }}</th>
                        </tr>
                        <tr>
                            <td>Alamat Karyawan</td>
                            <td>:</td>
                            <th>{{ $employee->employee_address }}</th>
                        </tr>
                        <tr>
                            <td>Dibuat Pada</td>
                            <td>:</td>
                            <th>{{ $employee->created_at->format('Y.m.d H:i') }}</th>
                        </tr>
                        <tr>
                            <td>Terakhir Diperbarui</td>
                            <td>:</td>
                            <th>{{ $employee->updated_at->diffForHumans() }}</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
