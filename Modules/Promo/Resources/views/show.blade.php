@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('vendor/dropify/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/owl-carousel-2/owl.theme.default.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Banner Promo
                </h5>
            </div>
            <div class="card-body">
                @include('layouts.flash-message')
                <figure>
                    <img src="{{ asset($promo->promo_banner) }}" class="d-block w-100" alt="{{ $promo->promo_name }}">
                    <figcaption class="d-flex justify-content-between align-items-center my-1">
                        {{ $promo->promo_name }}
                    </figcaption>
                </figure>
            </div>
        </div>
    </div>
    <div class="container-fluid my-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Detail Promo
                    </h5>
                    <a href="{{ route('promo.edit', $promo->promo_id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil-square"></i>
                        Edit Promo
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-borderless">
                        <tr>
                            <td>Nama Promo</td>
                            <td>:</td>
                            <th>{{ $promo->promo_name }}</th>
                        </tr>
                        <tr>
                            <td>Durasi Promo</td>
                            <td>:</td>
                            <th>{{ $promo->promo_started_at->format('Y.m.d H:i') }} s/d {{ $promo->promo_finished_at->format('Y.m.d H:i') }}</th>
                        </tr>
                        <tr>
                            <td>Tentang Promo</td>
                            <td>:</td>
                            <th>{{ $promo->promo_desc }}</th>
                        </tr>
                        <tr>
                            <td>Syarat dan Ketentuan</td>
                            <td>:</td>
                            <th>{{ $promo->promo_terms }}</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Produk dalam Promo
                    </h5>
{{--                    <a href="{{ route('promo.stock.create', ['promo' => $promo->promo_id]) }}" class="btn btn-sm btn-outline-primary">--}}
{{--                        <i class="bi bi-plus-circle"></i>--}}
{{--                        Tambah Produk Promo--}}
{{--                    </a>--}}
                </div>
            </div>
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-4">
                    @forelse($promo->relatedProducts as $product)
                        <div class="col my-3">
                            <div class="card h-100">
                                <img src="{{ asset($product->relatedPhotos[0]->image_url ?? 'image/AdobeStock_57930538.jpeg') }}" class="card-img-top" alt="{{ $product->relatedPhotos[0]->image_alt_text ?? 'Photo coming soon' }}" style="height: 150px; max-width: 100%; object-fit: cover">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center align-middle">
                                        <h5 class="card-title text-truncate">{{ $product->product_name }}</h5>
                                        <p class="card-text text-muted">Stok:{{ number_format($product->pivot->promo_product_stock ?? 0, 0, ',', '.') }}</p>
                                    </div>
                                    <p class="card-text">
                                        <small>Harga Jual : </small><br>
                                        <span class="text-danger"><s>{{ number_format($product->price_selling ?? 0, 0, ',', '.') }}</s></span>
                                        <br>
                                        {{ number_format($product->pivot->promo_price_selling ?? 0, 0, ',', '.') }}
                                    </p>
                                    <p class="card-text">{{ $product->product_description }}</p>
                                    <p class="card-text"><small class="text-muted">Terakhir diperbarui {{ $product->pivot->updated_at->diffForHumans() }}</small></p>
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

@push('script')
    <script src="{{ asset('vendor/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('vendor/owl-carousel-2/owl.carousel.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.dropify').dropify({
                messages: {
                    'default': 'Klik disini atau drag and drop',
                    'replace': 'Klik disini untuk mengganti atau drag and drop',
                    'remove':  'Hapus gambar',
                    'error':   'Maaf, sepertinya ada yang salah'
                }
            });
            $('.owl-carousel').owlCarousel();
        });
    </script>
@endpush
