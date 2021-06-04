@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">
                                Daftar Kategori
                            </h5>
                            <a href="{{ route('category.create') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-plus-circle"></i>
                                Tambah Kategori
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('layouts.flash-message')
                        <div class="row">
                            @forelse($categories as $category)
                                <div class="col-md-4 mx-0 my-3">
                                    <div class="card">
                                        <img src="{{ asset($category->category_icon) }}" class="card-img-top" alt="{{ $category->category_name }}" style="height: 150px; max-width: 100%; object-fit: cover">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $category->category_name }}</h5>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="card-text">{{ $category->related_products_count }} produk</p>
                                                <p class="card-text text-muted">Gender : {{ $category->category_gender_text }}</p>
                                            </div>
                                            <p class="card-text"><small class="text-muted">Terakhir diperbarui {{ $category->updated_at->diffForHumans() }}</small></p>
                                            <hr>
                                            <div class="btn-group" role="group" aria-label="Group Button {{ $category->category_id }}">
                                                <a href="{{ route('category.show', $category->category_id) }}">
                                                    <button type="submit" class="btn btn-secondary mx-1">Detail</button>
                                                </a>
                                                <a href="{{ route('category.edit', $category->category_id) }}">
                                                    <button type="button" class="btn btn-secondary mx-1">Edit</button>
                                                </a>
                                                <form action="{{ route('category.destroy', $category->category_id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-secondary mx-1" onclick="confirm('Apakah Anda yakin ingin menghapus ini?')">Hapus</button>
                                                </form>
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
        </div>
    </div>
@endsection
