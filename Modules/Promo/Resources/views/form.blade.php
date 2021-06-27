<div class="form-group">
    <label for="promo_name" class="col-form-label">Nama Promo</label>
    <input type="text" class="form-control @error('promo_name') is-invalid @enderror" name="promo_name" id="promo_name" value="{{ $promo->promo_name ?? old('promo_name') }}" required autofocus autocomplete="name">
    @error('promo_name')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="promo_started_at" class="col-form-label">Tanggal Mulai Promo</label>
        <input type="date" class="form-control @error('promo_started_at') is-invalid @enderror" name="promo_started_at" id="promo_started_at" value="{{ $promo->promo_started_at->format('Y-m-d') ?? old('promo_started_at') }}" required autofocus autocomplete="name">
        @error('promo_started_at')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="promo_finished_at" class="col-form-label">Tanggal Akhir Promo</label>
        <input type="date" class="form-control @error('promo_finished_at') is-invalid @enderror" name="promo_finished_at" id="promo_finished_at" value="{{ $promo->promo_finished_at->format('Y-m-d') ?? old('promo_finished_at') }}" required autofocus autocomplete="name">
        @error('promo_finished_at')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-group">
    <label for="promo_desc" class="col-form-label">Deskripsi Promo</label>
    <textarea class="form-control @error('promo_desc') is-invalid @enderror" name="promo_desc" id="promo_desc" rows="5" required>{{ $promo->promo_desc ?? old('promo_desc') }}</textarea>
    @error('promo_desc')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="promo_terms" class="col-form-label">Syarat dan Ketentuan Promo</label>
    <textarea class="form-control @error('promo_terms') is-invalid @enderror" name="promo_terms" id="promo_terms" rows="5" required>{{ $promo->promo_terms ?? old('promo_terms') }}</textarea>
    @error('promo_terms')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="promo_banner" class="col-form-label">Pilih Gambar</label>
    <input type="file" accept="image/*" class="form-control-file @error('promo_banner') is-invalid @enderror" name="promo_banner" id="promo_banner" value="{{ old('promo_banner') }}" @empty($promo->promo_banner) required @endempty aria-describedby="helpPromoBanner">
    <small id="helpPromoBanner" class="form-text text-muted">Hanya menerima gambar dengan format jpg, jpeg, atau png maks. 2MB</small>
    @error('promo_banner')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
@isset($promo->promo_banner)
    <label class="col-form-label">Banner Promo Sekarang</label>
    <img src="{{ asset($promo->promo_banner) }}" alt="{{ $promo->promo_name ?? 'Icon' }}" class="img-fluid rounded mt-0 mb-3">
@endisset
@isset($products)
<label class="col-form-label">Pilih Produk</label>
<div class="repeater">
    <div class="my-3" data-repeater-list="products">
        <div class="form-inline" data-repeater-item>
            <label for="product_id" class="sr-only">Nama Produk</label>
            <select class="form-control mb-2 mr-sm-2" name="product_id" id="product_id" required>
                <option disabled selected>Silahkan pilih</option>
                @forelse($products as $product)
                    <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                @empty
                    <option disabled>Tidak ada produk</option>
                @endforelse
            </select>
            <label for="promo_product_stock" class="sr-only">Stok Promo</label>
            <input type="text" class="form-control mb-2 mr-sm-2" name="promo_product_stock" id="promo_product_stock" placeholder="Stok Promo" required>
            <label for="promo_price_supplier" class="sr-only">Harga Beli (Harga dari Supplier)</label>
            <input type="text" class="form-control mb-2 mr-sm-2" name="promo_price_supplier" id="promo_price_supplier" placeholder="Harga Beli selama Promo" required>
            <label for="promo_price_selling" class="sr-only">Harga Beli (Harga dari Supplier)</label>
            <input type="text" class="form-control mb-2 mr-sm-2" name="promo_price_selling" id="promo_price_selling" placeholder="Harga Jual selama Promo" required>
            <input type="button" value="Hapus" class="btn btn-danger ml-2" data-repeater-delete/>
        </div>
    </div>
    <input type="button" value="Tambah produk" class="btn btn-secondary mb-2" data-repeater-create/>
</div>
@endisset
<button type="submit" class="btn btn-block btn-primary">Simpan Perubahan</button>
