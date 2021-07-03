@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Daftar Pesanan</h5>
            </div>
            <div class="card-body">
                @include('layouts.flash-message')
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Aksi</th>
                            <th>Status</th>
                            <th>Nomor Pesanan</th>
                            <th>Tanggal</th>
                            <th>Total (Rp)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Group Button {{ $order->order_id }}">
                                        <a href="{{ route('order.show', $order->order_id) }}">
                                            <button type="submit" class="btn btn-secondary mx-1">Detail</button>
                                        </a>
                                        <a href="{{ route('order.edit', $order->order_id) }}">
                                            <button type="button" class="btn btn-secondary mx-1">Edit</button>
                                        </a>
                                    </div>
                                </td>
                                <td>{{ $order->order_latest_status }}</td>
                                <td>{{ $order->order_no }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>{{ number_format($order->order_total ?? 0, 0, ',', '.') }}</td>
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
