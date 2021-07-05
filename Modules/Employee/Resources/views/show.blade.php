@extends('layouts.app')

@section('content')
    <div class="container-fluid mb-3">
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
    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Produk Punya Karyawan
                    </h5>
                    <a href="{{ route('product.create', ['employee_id' => $employee->employee_id]) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Produk
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-4">
                    @forelse($employee->relatedProducts as $product)
                        <div class="col my-3">
                            <div class="card h-100">
                                <img src="{{ asset($product->relatedPhotos[0]->image_url ?? 'image/AdobeStock_57930538.jpeg') }}" class="card-img-top" alt="{{ $product->relatedPhotos[0]->image_alt_text ?? 'Photo coming soon' }}" style="height: 150px; max-width: 100%; object-fit: cover">
                                <div class="card-body">
                                    <a href="{{ route('category.show', $product->category_id) }}">
                                        <small>Kategori {{ $product->relatedCategory->category_name }}</small>
                                    </a>
                                    <div class="d-flex justify-content-between align-items-center align-middle">
                                        <h5 class="card-title text-truncate">{{ $product->product_name }}</h5>
                                        <p class="text-muted">Stok:{{ number_format($product->product_stock ?? 0, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center align-middle">
                                        <p>
                                            <small>Harga Karyawan : </small>
                                            <br>
                                            {{ number_format($product->price_employee ?? 0, 0, ',', '.') }}
                                        </p>
                                        <p>
                                            <small>Harga Jual : </small>
                                            <br>
                                            {{ number_format($product->price_selling ?? 0, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <p class="card-text">{{ $product->product_description }}</p>
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
