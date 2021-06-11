<div class="form-group">
    <label for="product_name" class="col-form-label">Nama Produk</label>
    <input type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name" id="product_name" value="{{ $product->product_name ?? old('product_name') }}" required autofocus autocomplete="name">
    @error('product_name')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div><label for="category_id" class="col-form-label">Pilih Kategori</label>
<div class="form-group">
    @foreach($categories as $category)
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="category_id" id="category{{ $category->category_id }}" value="{{ $category->category_id }}" {{ ($product->category_id ?? old('category_id')) == $category->category_id ? 'checked' : '' }}>
            <label class="form-check-label" for="category{{ $category->category_id }}">{{ $category->category_name }}</label>
        </div>
    @endforeach
    @error('category_id')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="supplier_id">Pilih Supplier</label>
    <select class="form-control @error('product_name') is-invalid @enderror" name="supplier_id" id="supplier_id" required>
        <option disabled selected>Silahkan pilih</option>
        @forelse($suppliers as $supplier)
            <option value="{{ $supplier->supplier_id }}" {{ $product->supplier_id ?? old('supplier_id') == $supplier->supplier_id ? 'selected' : '' }}>{{ $supplier->supplier_name }}</option>
        @empty
            <option disabled>Belum ada Supplier terdaftar</option>
        @endforelse
    </select>
    @error('category_id')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="price_supplier" class="col-form-label">Harga Beli (Harga dari Supplier)</label>
        <input type="number" min="0" class="form-control @error('price_supplier') is-invalid @enderror" name="price_supplier" id="price_supplier" value="{{ $product->price_supplier ?? old('price_supplier') }}" required>
        @error('price_supplier')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="price_selling" class="col-form-label">Harga Jual</label>
        <input type="number" min="0" class="form-control @error('price_selling') is-invalid @enderror" name="price_selling" id="price_selling" value="{{ $product->price_selling ?? old('price_selling') }}" required>
        @error('price_selling')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-group">
    <label for="product_description" class="col-form-label">Deskripsi Produk</label>
    <textarea class="form-control @error('product_description') is-invalid @enderror" name="product_description" id="product_description" rows="5" required>{{ $product->product_description ?? old('product_description') }}</textarea>
    @error('product_description')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="product_guarantee" class="col-form-label">Garansi Produk (Opsional)</label>
    <textarea class="form-control @error('product_guarantee') is-invalid @enderror" name="product_guarantee" id="product_guarantee" rows="5">{{ $product->product_guarantee ?? old('product_guarantee') }}</textarea>
    @error('product_guarantee')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
@empty($product)
    <div class="form-group">
        <label for="product_stock" class="col-form-label">Stok Awal</label>
        <input type="number" min="0" max="100" class="form-control @error('product_stock') is-invalid @enderror" name="product_stock" id="product_stock" value="{{ old('product_stock') }}" required>
        @error('product_stock')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="product_image" class="col-form-label">Pilih Gambar</label>
        <input type="file" class="form-control-file @error('product_image') is-invalid @enderror" name="product_image" id="product_image" value="{{ old('product_image') }}" @empty($product->product_image) required @endempty aria-describedby="helpProductImage">
        <small id="helpProductImage" class="form-text text-muted">Hanya menerima gambar dengan format jpg, jpeg, atau png maks. 2MB</small>
        @error('product_image')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
@endempty
<button type="submit" class="btn btn-block btn-primary">Simpan Perubahan</button>
