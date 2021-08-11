@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Daftar Komplain</h5>
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
                            <th>Kategori</th>
                            <th>Penjelasan</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($complains as $complain)
                        {{$complain->relatedOrder->sortBy('order_no', [], true)}}
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Group Button {{ $complain->complain_id }}">
                                        <a href="{{ route('complain.show', $complain->complain_id) }}">
                                            <button type="submit" class="btn btn-secondary mx-1">Detail</button>
                                        </a>
                                        <a href="{{ route('complain.edit', $complain->complain_id) }}">
                                            <button type="button" class="btn btn-secondary mx-1">Update Status</button>
                                        </a>
                                    </div>
                                </td>
                                <td>{{ $complain->complain_status_desc }}</td>
                                <td>{{ $complain->relatedOrder->order_no }}</td>
                                <t>{{ $complain->complain_category }}</t   d>
                                <td>
                                    {{ $complain->complain_description }}
                                    @isset($complain->complain_attachment)
                                        <a href="{{ asset($complain->complain_attachment) }}" target="_blank">
                                            <i class="bi bi-paperclip"></i>
                                            Lampiran
                                        </a>
                                    @endisset
                                </td>
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
