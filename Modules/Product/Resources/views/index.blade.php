@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">
                                Daftar Produk
                            </h5>
                            <a href="{{ route('product.create') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-plus-circle"></i>
                                Tambah Produk
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('layouts.flash-message')
                        <div class="row row-cols-1 row-cols-md-3">
                            @forelse($products as $product)
                                <div class="col my-3">
                                    <div class="card h-100">
                                        <img src="{{ asset($product->relatedPhotos[0]->image_url) }}" class="card-img-top" alt="{{ $product->relatedPhotos[0]->image_alt_text }}" style="height: 150px; max-width: 100%; object-fit: cover">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->product_name }}</h5>
                                            <p class="card-text">{{ $product->price_selling }}</p>
                                            <p class="card-text">{{ $product->product_description }}</p>
                                            <p class="card-text text-muted">Stok : {{ $product->product_stock }}</p>
                                            <p class="card-text"><small class="text-muted">Terakhir diperbarui {{ $product->updated_at->diffForHumans() }}</small></p>
                                            <hr>
                                            <div class="btn-group" role="group" aria-label="Group Button {{ $product->product_id }}">
                                                <a href="{{ route('product.show', $product->product_id) }}">
                                                    <button type="submit" class="btn btn-secondary mx-1">Detail</button>
                                                </a>
                                                <a href="{{ route('product.edit', $product->product_id) }}">
                                                    <button type="button" class="btn btn-secondary mx-1">Edit</button>
                                                </a>
                                                <form action="{{ route('product.destroy', $product->product_id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-secondary mx-1" onclick="confirm('Apakah Anda yakin ingin menghapus ini?')">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-md-12">
                                    <p>Belum ada data.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
