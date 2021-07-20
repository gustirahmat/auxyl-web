@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Daftar Pesanan</h5>
            </div>
            <div class="card-body">
                @include('layouts.flash-message')
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{ $dataTable->scripts() }}
@endpush