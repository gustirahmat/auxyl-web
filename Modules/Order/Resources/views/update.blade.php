@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Verifikasi Pesanan
                    </h5>
                    <a href="{{ route('order.index') }}" class="btn btn-sm btn-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg text-danger" viewBox="0 0 16 16">
                            <path d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.flash-message')
                <form action="{{ route('order.update', $order->order_id) }}" method="post" accept-charset="UTF-8">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="order_status">Status Pesanan</label>
                        <input type="text" class="form-control" id="order_status" value="{{ $order->order_status ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="customer_name">Nama Pemesan</label>
                        <input type="text" class="form-control" id="customer_name" value="{{ $order->relatedCustomer->customer_name ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="order_no">Nomor Pesanan</label>
                        <input type="text" class="form-control" id="order_no" value="{{ $order->order_no ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="order_date">Tanggal Pesanan</label>
                        <input type="date" class="form-control" id="order_date" value="{{ $order->order_date->format('Y-m-d') ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="order_payment_proof">Bukti Bayar</label>
                        @isset($order->order_payment_proof)
                            <img src="{{ asset($order->order_payment_proof) }}" alt="{{ $order->order_no ?? 'Bukti bayar' }}" class="img-fluid rounded my-3">
                        @else
                            <input type="text" readonly class="form-control" id="order_payment_proof" value="Belum ada">
                        @endisset
                    </div>
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_valid" id="inlineRadio1" value="1">
                            <label class="form-check-label" for="inlineRadio1">Valid</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_valid" id="inlineRadio2" value="0">
                            <label class="form-check-label" for="inlineRadio2">Tidak Valid</label>
                        </div>
                        @error('is_valid')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status_reason" class="col-form-label">Masukkan alasan jika tidak valid</label>
                        <input type="text" class="form-control @error('status_reason') is-invalid @enderror" name="status_reason" id="status_reason" value="{{ old('status_reason') }}">
                        @error('status_reason')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-block btn-primary">Simpan Perubahan</button>
                </form>
            </div>
            <div class="card-footer text-right">
                <form action="{{ route('order.destroy', $order->order_id) }}" method="post" onsubmit="confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-outline-danger">Batalkan Pesanan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
