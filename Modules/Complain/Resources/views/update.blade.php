@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Update Status Komplain
                    </h5>
                    <a href="{{ route('complain.index') }}" class="btn btn-sm btn-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg text-danger" viewBox="0 0 16 16">
                            <path d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.flash-message')
                <form action="{{ route('complain.update', $complain->complain_id) }}" method="post" accept-charset="UTF-8">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="customer_name">Nama Pemesan</label>
                        <input type="text" class="form-control" id="customer_name" value="{{ $complain->relatedOrder->relatedCustomer->customer_name ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="complain_no">Nomor Pesanan</label>
                        <input type="text" class="form-control" id="complain_no" value="{{ $complain->relatedOrder->order_no ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="created_at">Tanggal Komplain</label>
                        <input type="date" class="form-control" id="created_at" value="{{ $complain->created_at->format('Y-m-d') ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="complain_category">Kategori Komplain</label>
                        <input type="text" class="form-control" id="complain_category" value="{{ $complain->complain_category ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="complain_description">Alasan Komplain</label>
                        <textarea class="form-control" id="complain_description" rows="5" readonly>{{ $complain->complain_description ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="complain_attachment">Lampiran</label>
                        @isset($complain->complain_attachment)
                            <img src="{{ asset($complain->complain_attachment) }}" alt="{{ $complain->complain_id ?? 'Lampiran Komplain' }}" class="img-fluid rounded my-3">
                        @else
                            <input type="text" readonly class="form-control" id="complain_attachment" value="Belum ada">
                        @endisset
                    </div>
                    <div class="form-group">
                        <label for="complain_status">Status Komplain</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="complain_status" id="complain_status1" value="1" @if($complain->complain_status == 1) checked @endif>
                            <label class="form-check-label" for="complain_status1">
                                Open
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="complain_status" id="complain_status2" value="2" @if($complain->complain_status == 2) checked @endif>
                            <label class="form-check-label" for="complain_status2">
                                In Progress
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="complain_status" id="complain_status3" value="3" @if($complain->complain_status == 3) checked @endif>
                            <label class="form-check-label" for="complain_status3">
                                Closed
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="complain_resolution" class="col-form-label">Masukkan solusi penyelesaian komplain</label>
                        <textarea class="form-control @error('complain_resolution') is-invalid @enderror" name="complain_resolution" id="complain_resolution" rows="5" autofocus required>{{ $complain->complain_resolution ?? '' }}</textarea>
                        @error('complain_resolution')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-block btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
