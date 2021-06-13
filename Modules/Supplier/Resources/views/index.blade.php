@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Daftar Supplier
                    </h5>
                    <a href="{{ route('supplier.create') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Supplier
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
                            <th>Nama Supplier</th>
                            <th>Telp/WA</th>
                            <th>Alamat</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($suppliers as $supplier)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Group Button {{ $supplier->supplier_id }}">
                                        <a href="{{ route('supplier.show', $supplier->supplier_id) }}">
                                            <button type="submit" class="btn btn-secondary mx-1">Detail</button>
                                        </a>
                                        <a href="{{ route('supplier.edit', $supplier->supplier_id) }}">
                                            <button type="button" class="btn btn-secondary mx-1">Edit</button>
                                        </a>
                                    </div>
                                </td>
                                <td>{{ $supplier->supplier_name }}</td>
                                <td>{{ $supplier->supplier_phone }}</td>
                                <td>{{ $supplier->supplier_address }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Tidak ada data.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
