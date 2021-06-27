@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Daftar Promo
                    </h5>
                    <a href="{{ route('promo.create') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Promo
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
                            <th>Nama Promo</th>
                            <th>Jumlah Produk</th>
                            <th>Mulai Dari</th>
                            <th>Sampai Dengan</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($promos as $promo)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Group Button {{ $promo->promo_id }}">
                                        <a href="{{ route('promo.show', $promo->promo_id) }}">
                                            <button type="submit" class="btn btn-secondary mx-1">Detail</button>
                                        </a>
                                        <a href="{{ route('promo.edit', $promo->promo_id) }}">
                                            <button type="button" class="btn btn-secondary mx-1">Edit</button>
                                        </a>
                                    </div>
                                </td>
                                <td>{{ $promo->promo_name }}</td>
                                <td>{{ $promo->related_products_count }}</td>
                                <td>{{ $promo->promo_started_at->format('Y.m.d H:i') }}</td>
                                <td>{{ $promo->promo_finished_at->format('Y.m.d H:i') }}</td>
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
