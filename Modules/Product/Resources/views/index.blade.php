@extends('layouts.app')

@section('content')
    <div class="container-fluid">
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
                <div class="row row-cols-1 row-cols-md-4">
                    @forelse($products as $product)
                        <div class="col my-3">
                            <div class="card h-100">
                                @if($product->relatedPhotos()->exists())
                                    <img src="{{ app()->environment('production') ? $product->relatedPhotos[0]->image_url : asset($product->relatedPhotos[0]->image_url ?? 'image/AdobeStock_57930538.jpeg') }}" class="card-img-top" alt="{{ $product->relatedPhotos[0]->image_alt_text ?? 'Photo coming soon' }}" style="height: 150px; max-width: 100%; object-fit: cover">
                                @else
                                    <img src="{{ asset('image/AdobeStock_57930538.jpeg') }}" class="card-img-top" alt="Photo coming soon" style="height: 150px; max-width: 100%; object-fit: cover">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title text-truncate">{{ $product->product_name }}</h5>
                                    <p class="card-text">
                                        <small>Harga Jual : </small><br>
                                        {{ number_format($product->price_selling ?? 0, 0, ',', '.') }}
                                    </p>
                                    <p class="card-text">{{ $product->product_description }}</p>
                                    <p class="text-muted">
                                        Stok : {{ number_format($product->product_stock ?? 0, 0, ',', '.') }}
                                        <a href="{{ route('product.stock.index', ['product' => $product->product_id]) }}">Lihat histori</a>
                                    </p>
                                    <p class="card-text"><small class="text-muted">Terakhir diperbarui {{ $product->updated_at->diffForHumans() }}</small></p>
                                    <hr>
                                    <div class="btn-group" role="group" aria-label="Group Button {{ $product->product_id }}">
                                        <a href="{{ route('product.show', $product->product_id) }}">
                                            <button type="submit" class="btn btn-secondary mx-1">Detail</button>
                                        </a>
                                        <a href="{{ route('product.edit', $product->product_id) }}">
                                            <button type="button" class="btn btn-secondary mx-1">Edit</button>
                                        </a>
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
@endsection
