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
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Gambar Produk
                    </h5>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalNewPhoto">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Gambar
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="modalNewPhoto" tabindex="-1" aria-labelledby="modalLabelNewPhoto" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('product.image.store', ['product' => $product->product_id]) }}" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabelNewPhoto">Upload Gambar Baru</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @csrf

                                        <div class="form-group">
                                            <label for="image_url" class="col-form-label">Gambar Baru</label>
                                            <input type="file" accept="image/*" class="dropify" name="image_url" id="image_url" data-max-file-size="2M" required/>
                                        </div>
                                        <div class="form-group">
                                            <label for="image_alt_text" class="col-form-label">Caption</label>
                                            <input type="text" class="form-control" name="image_alt_text" id="image_alt_text" placeholder="cth: Tampak depan" aria-label="Caption" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                                        <button type="submit" class="btn btn-primary">Upload Gambar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.flash-message')
                <div class="owl-carousel owl-theme">
                    @forelse($product->relatedPhotos as $photo)
                        <div class="item">
                            <figure>
                                <img src="{{ app()->environment('production') ? $photo->image_url : asset($photo->image_url) }}" class="d-block w-100" alt="{{ $photo->image_alt_text }}">
                                <figcaption class="d-flex justify-content-between align-items-center my-1">
                                    {{ $photo->image_alt_text }}
                                    <form action="{{ route('product.image.destroy', ['product' => $product->product_id, 'image' => $photo->id]) }}" method="post" onsubmit="confirm('Apakah Anda yakin ingin menghapus ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </figcaption>
                            </figure>
                        </div>
                    @empty
                        <div class="item">
                            <img src="{{ asset('image/AdobeStock_57930538.jpeg') }}" class="d-block w-100" alt="Photo coming soon">
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid my-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Detail Produk
                    </h5>
                    <a href="{{ route('product.edit', $product->product_id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil-square"></i>
                        Edit Produk
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-borderless">
                        <tr>
                            <td>Nomor SKU</td>
                            <td>:</td>
                            <th>{{ $product->product_sku }}</th>
                        </tr>
                        <tr>
                            <td>Nama Produk</td>
                            <td>:</td>
                            <th>{{ $product->product_name }}</th>
                        </tr>
                        <tr>
                            <td>Stok Saat Ini</td>
                            <td>:</td>
                            <th>{{ number_format($product->product_stock ?? 0, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <td>Harga dari Supplier (Rp)</td>
                            <td>:</td>
                            <th>{{ number_format($product->price_supplier ?? 0, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <td>Harga Jual (Rp)</td>
                            <td>:</td>
                            <th>{{ number_format($product->price_selling ?? 0, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <td>Deskripsi</td>
                            <td>:</td>
                            <th>{{ $product->product_description }}</th>
                        </tr>
                        <tr>
                            <td>Garansi</td>
                            <td>:</td>
                            <th>{{ $product->product_guarantee }}</th>
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
                        Histori Stok
                    </h5>
                    <a href="{{ route('product.stock.create', ['product' => $product->product_id]) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Stok
                    </a>
                </div>
            </div>
            <div class="card-body">
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
