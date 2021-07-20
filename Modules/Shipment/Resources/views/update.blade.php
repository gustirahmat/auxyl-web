@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Update Informasi Pengiriman
                    </h5>
                    <a href="{{ route('shipment.index') }}" class="btn btn-sm btn-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg text-danger" viewBox="0 0 16 16">
                            <path d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.flash-message')
                <form action="{{ route('shipment.update', $delivery->delivery_id) }}" method="post" accept-charset="UTF-8">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="delivery_status">Status Pesanan</label>
                        <input type="text" class="form-control" id="delivery_status" value="{{ $delivery->relatedOrder->order_status ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="customer_name">Nama Pemesan</label>
                        <input type="text" class="form-control" id="customer_name" value="{{ $delivery->relatedOrder->relatedCustomer->customer_name ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="delivery_contact_name">Nama Penerima Paket</label>
                        <input type="text" class="form-control" id="delivery_contact_name" value="{{ $delivery->delivery_contact_name ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="delivery_contact_phone">Nomor Penerima Paket</label>
                        <input type="text" class="form-control" id="delivery_contact_phone" value="{{ $delivery->delivery_contact_phone ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="delivery_max_date">Tanggal Maksimal Pengiriman Paket</label>
                        <input type="date" class="form-control" id="delivery_max_date" value="{{ $delivery->delivery_max_date ? $delivery->delivery_max_date->format('Y-m-d') : '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="delivery_act_date">Tanggal Aktual Pengiriman Paket</label>
                        <input type="date" class="form-control @error('delivery_act_date') is-invalid @enderror" name="delivery_act_date" id="delivery_act_date" value="{{ $delivery->delivery_act_date ? $delivery->delivery_act_date->format('Y-m-d') : '' }}" required>
                        @error('delivery_act_date')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="delivery_est_date">Tanggal Estimasi Terima Paket</label>
                        <input type="date" class="form-control @error('delivery_est_date') is-invalid @enderror" name="delivery_est_date" id="delivery_est_date" value="{{ $delivery->delivery_est_date ? $delivery->delivery_est_date->format('Y-m-d') : '' }}" required>
                        @error('delivery_est_date')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @if($delivery->delivery_rcv_date == 3)
                        <div class="form-group">
                            <label for="delivery_rcv_date">Tanggal Aktual Terima Paket</label>
                            <input type="date" class="form-control @error('delivery_rcv_date') is-invalid @enderror" name="delivery_rcv_date" id="delivery_rcv_date" value="{{ $delivery->delivery_rcv_date ? $delivery->delivery_rcv_date->format('Y-m-d') : '' }}" required>
                            @error('delivery_rcv_date')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    <button type="submit" class="btn btn-block btn-primary">Simpan Perubahan</button>
                </form>
            </div>
            <div class="card-footer text-right">
                <form action="{{ route('shipment.destroy', $delivery->delivery_id) }}" method="post" onsubmit="confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-outline-danger">Batalkan Pesanan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
