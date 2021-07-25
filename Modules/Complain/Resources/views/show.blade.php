@extends('layouts.app')

@section('content')
    <div class="container-fluid mb-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Detail Komplain
                    </h5>
                    <a href="{{ route('complain.edit', $complain->complain_id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil-square"></i>
                        Update Status
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.flash-message')
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-borderless">
                        <tr>
                            <td>Status Komplain</td>
                            <td>:</td>
                            <th>
                                {{ $complain->complain_status_desc }}
                            </th>
                        </tr>
                        <tr>
                            <td>Kategori Komplain</td>
                            <td>:</td>
                            <th>
                                {{ $complain->complain_category }}
                            </th>
                        </tr>
                        <tr>
                            <td>Alasan Komplain</td>
                            <td>:</td>
                            <th>
                                {{ $complain->complain_description }}
                            </th>
                        </tr>
                        <tr @if($complain->complain_status !== 3) class="bg-danger text-light" @else class="bg-success text-dark" @endempty>
                            <td>Penyelesaian Komplain</td>
                            <td>:</td>
                            <th>
                                {{ $complain->complain_resolution }}
                            </th>
                        </tr>
                        <tr>
                            <td>Lampiran</td>
                            <td>:</td>
                            <th>
                                @isset($complain->complain_attachment)
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p>{{ $complain->complain_attachment }}</p>
                                        <a href="{{ $complain->complain_attachment }}">Lihat</a>
                                    </div>
                                @else
                                    Tidak ada lampiran.
                                @endisset
                            </th>
                        </tr>
                        <tr>
                            <td>Dibuat Pada</td>
                            <td>:</td>
                            <th>{{ $complain->created_at->format('Y.m.d H:i') }}</th>
                        </tr>
                        <tr>
                            <td>Terakhir Diperbarui</td>
                            <td>:</td>
                            <th>{{ $complain->updated_at->diffForHumans() }}</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid my-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Detail Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-borderless">
                        <tr>
                            <td>Nomor Pesanan</td>
                            <td>:</td>
                            <th>
                                {{ $order->order_no }}
                            </th>
                        </tr>
                        <tr>
                            <td>Tanggal Pesanan</td>
                            <td>:</td>
                            <th>
                                {{ $order->order_date->format('Y.m.d') }}
                            </th>
                        </tr>
                        <tr>
                            <td>Nama Pemesan</td>
                            <td>:</td>
                            <th>
                                {{ $order->relatedCustomer->customer_name }}
                            </th>
                        </tr>
                        <tr>
                            <td>Alamat Email</td>
                            <td>:</td>
                            <th>
                                {{ $order->relatedCustomer->relatedUser->email }}
                            </th>
                        </tr>
                        <tr>
                            <td>Total Pesanan</td>
                            <td>:</td>
                            <th>
                                {{ number_format($order->order_total ?? 0, 0, ',', '.') }}
                            </th>
                        </tr>
                        <tr>
                            <td>Bukti Bayar</td>
                            <td>:</td>
                            <th>
                                @isset($order->order_payment_proof)
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p>{{ $order->order_payment_proof }}</p>
                                        <div>
                                            <a href="{{ $order->order_payment_proof }}">Lihat</a>
                                            &nbsp;&nbsp;&nbsp;
                                            @if($order->order_latest_status == 1)
                                                <a href="{{ route('order.edit', $order->order_id) }}">Verifikasi</a>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    Belum ada.
                                @endisset
                            </th>
                        </tr>
                        <tr>
                            <td>Nama Penerima Barang</td>
                            <td>:</td>
                            <th>
                                {{ $order->relatedDelivery->delivery_contact_name }}
                            </th>
                        </tr>
                        <tr>
                            <td>Nomor Kontak Penerima</td>
                            <td>:</td>
                            <th>
                                {{ $order->relatedDelivery->delivery_contact_phone }}
                            </th>
                        </tr>
                        <tr>
                            <td>Alamat Pesanan</td>
                            <td>:</td>
                            <th>
                                Alamat : {{ $order->relatedDelivery->delivery_address }} <br>
                                Kode Pos : {{ $order->relatedDelivery->delivery_zipcode }} <br>
                                Kelurahan : {{ $order->relatedDelivery->delivery_kelurahan }} <br>
                                Kecamatan : {{ $order->relatedDelivery->delivery_kecamatan }} <br>
                                Kabupaten/Kota : {{ $order->relatedDelivery->delivery_kabkot }} <br>
                                Provinsi : {{ $order->relatedDelivery->delivery_provinsi }} <br>
                            </th>
                        </tr>
                        <tr>
                            <td>Status Pesanan</td>
                            <td>:</td>
                            <th>
                                {{ $order->order_status }}
                            </th>
                        </tr>
                        <tr>
                            <td>Dibuat Pada</td>
                            <td>:</td>
                            <th>{{ $order->created_at->format('Y.m.d H:i') }}</th>
                        </tr>
                        <tr>
                            <td>Terakhir Diperbarui</td>
                            <td>:</td>
                            <th>{{ $order->updated_at->diffForHumans() }}</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid my-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Produk Yg Dibeli</h5>
            </div>
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-4">
                    @forelse($order->relatedProducts as $product)
                        <div class="col my-3">
                            <div class="card h-100">
                                <img src="{{ asset($product->relatedPhotos[0]->image_url ?? 'image/AdobeStock_57930538.jpeg') }}" class="card-img-top" alt="{{ $product->relatedPhotos[0]->image_alt_text ?? 'Photo coming soon' }}" style="height: 150px; max-width: 100%; object-fit: cover">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center align-middle">
                                        <h5 class="card-title text-truncate">{{ $product->relatedProduct->product_name }}</h5>
                                        <p class="text-muted">Qty : {{ number_format($product->order_product_qty ?? 0, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center align-middle">
                                        <p>
                                            <small>Harga Produk : </small>
                                            <br>
                                            {{ number_format($product->order_product_price ?? 0, 0, ',', '.') }}
                                        </p>
                                        <p>
                                            <small>Subtotal : </small>
                                            <br>
                                            {{ number_format($product->order_product_subtotal ?? 0, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <p class="card-text">
                                        <small>Tentang Produk</small>
                                        <br>
                                        {{ $product->relatedProduct->product_description }}
                                    </p>
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
    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Histori Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="text-center">
                        <tr>
                            <th class="align-middle" rowspan="2">No</th>
                            <th class="align-middle" rowspan="2">Status</th>
                            <th class="align-middle" rowspan="2">Catatan</th>
                            <th colspan="2">Dibuat Pada</th>
                        </tr>
                        <tr>
                            <th>Jam</th>
                            <th>Tanggal</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->relatedStatuses as $status)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucwords($status->status_action) }}</td>
                                <td class="text-left">{{ ucwords($status->status_comment) }}</td>
                                <td>{{ $status->created_at->translatedFormat('H:i:s') }}</td>
                                <td>{{ $status->created_at->translatedFormat('d-M-Y') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
