@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Tambah Histori Stok Baru
                    </h5>
                    <a href="{{ route('product.stock.index', ['product' => $product->product_id]) }}" class="btn btn-sm btn-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg text-danger" viewBox="0 0 16 16">
                            <path d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.flash-message')
                <form action="{{ route('product.stock.store', ['product' => $product->product_id]) }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="product_name" class="col-sm-2 col-form-label">Nama Produk</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" name="product_name" id="product_name" value="{{ $product->product_name }}">
                        </div>
                    </div>
                    <div class="row">
                        <label for="stock_status" class="col-sm-2 col-form-label">Status Stok</label>
                        <div class="form-group col-sm-10">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="stock_status" id="stock_status0" value="0">
                                <label class="form-check-label" for="stock_status0">Keluar</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="stock_status" id="stock_status1" value="1">
                                <label class="form-check-label" for="stock_status1">Masuk</label>
                            </div>
                            @error('stock_status')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stock_qty" class="col-form-label">Jumlah Stok</label>
                        <input type="number" min="1" max="100" class="form-control @error('stock_qty') is-invalid @enderror" name="stock_qty" id="stock_qty" value="{{ old('stock_qty') }}" required>
                        @error('stock_qty')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="stock_notes" class="col-form-label">Keterangan (Opsional)</label>
                        <input type="text" class="form-control @error('stock_notes') is-invalid @enderror" name="stock_notes" id="stock_notes" value="{{ old('stock_notes') }}" autocomplete="off">
                        @error('stock_notes')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-block btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
