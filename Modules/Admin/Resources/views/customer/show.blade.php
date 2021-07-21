@extends('layouts.app')

@section('content')
    <div class="container-fluid mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Detail Customer</h5>
            </div>
            <div class="card-body">
                @include('layouts.flash-message')
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-borderless">
                        <tr>
                            <td>Nama Customer</td>
                            <td>:</td>
                            <th>{{ $customer->customer_name }}</th>
                        </tr>
                        <tr>
                            <td>No. Telp. / WhatsApp (WA)</td>
                            <td>:</td>
                            <th>{{ $customer->customer_phone }}</th>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <th>{{ $customer->relatedUser->email }}</th>
                        </tr>
                        <tr>
                            <td>Lokasi Customer</td>
                            <td>:</td>
                            <th>
                                Alamat : {{ $customer->customer_address }} <br>
                                Kode Pos : {{ $customer->customer_zipcode }} <br>
                                Kelurahan : {{ $customer->customer_kelurahan }} <br>
                                Kecamatan : {{ $customer->customer_kecamatan }} <br>
                                Kabupaten/Kota : {{ $customer->customer_kabkot }} <br>
                                Provinsi : {{ $customer->customer_provinsi }} <br>
                            </th>
                        </tr>
                        <tr>
                            <td>Dibuat Pada</td>
                            <td>:</td>
                            <th>{{ $customer->created_at->format('Y.m.d H:i') }}</th>
                        </tr>
                        <tr>
                            <td>Terakhir Diperbarui</td>
                            <td>:</td>
                            <th>{{ $customer->updated_at->diffForHumans() }}</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Pesanan Punya Customer</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Aksi</th>
                            <th>Nomor Pesanan</th>
                            <th>Tanggal Pesanan</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($customer->relatedOrders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('order.show', $order->order_id) }}">
                                        <button type="submit" class="btn btn-secondary">Detail</button>
                                    </a>
                                </td>
                                <td>{{ $order->order_no }}</td>
                                <td>{{ $order->order_date->format('Y.m.d') }}</td>
                                <td>{{ number_format($order->order_total ?? 0, 0, ',', '.') }}</td>
                                <td>{{ $order->order_status }}</td>
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
