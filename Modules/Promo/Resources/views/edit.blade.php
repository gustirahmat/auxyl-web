@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Edit Promo
                    </h5>
                    <a href="{{ route('promo.index') }}" class="btn btn-sm btn-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg text-danger" viewBox="0 0 16 16">
                            <path d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.flash-message')
                <form action="{{ route('promo.update', $promo->promo_id) }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    @include('promo::form')
                </form>
            </div>
            <div class="card-footer text-right">
                <form action="{{ route('promo.destroy', $promo->promo_id) }}" method="post" onsubmit="confirm('Apakah Anda yakin ingin menghapus ini?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-outline-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
@endsection
