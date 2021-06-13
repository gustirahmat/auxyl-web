@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Histori Stok Produk {{ $product->product_name }}
                    </h5>
                    <a href="{{ route('product.stock.create', ['product' => $product->product_id]) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Stok
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.flash-message')
                <p class="font-weight-bold">Stok saat ini : {{ $product->product_stock }} barang</p>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Status</th>
                            <th>Qty</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($product->relatedStocks as $stock)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $stock->stock_status ? 'Masuk' : 'Keluar' }}</td>
                                <td>{{ $stock->stock_qty }}</td>
                                <td>{{ $stock->stock_notes }}</td>
                                <td>{{ $stock->created_at }}</td>
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
