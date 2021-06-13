<div class="form-group">
    <label for="category_name" class="col-form-label">Nama Kategori</label>
    <input type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name" id="category_name" value="{{ $category->category_name ?? old('category_name') }}" required autofocus autocomplete="name">
    @error('category_name')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<label for="category_gender" class="col-form-label">Untuk Pria/Wanita</label>
<div class="form-group">
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="category_gender" id="genderWoman" value="0" {{ ($category->category_gender ?? old('category_gender')) == 0 ? 'checked' : '' }}>
        <label class="form-check-label" for="genderWoman">Wanita</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="category_gender" id="genderMan" value="1" {{ ($category->category_gender ?? old('category_gender')) == 1 ? 'checked' : '' }}>
        <label class="form-check-label" for="genderMan">Pria</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="category_gender" id="genderUnisex" value="2" {{ ($category->category_gender ?? old('category_gender')) == 2 ? 'checked' : '' }}>
        <label class="form-check-label" for="genderUnisex">Unisex</label>
    </div>
    @error('category_gender')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="category_icon" class="col-form-label">Pilih Gambar</label>
    <input type="file" accept="image/*" class="form-control-file @error('category_icon') is-invalid @enderror" name="category_icon" id="category_icon" value="{{ old('category_icon') }}" @empty($category->category_icon) required @endempty aria-describedby="helpCategoryIcon">
    <small id="helpCategoryIcon" class="form-text text-muted">Hanya menerima gambar dengan format jpg, jpeg, atau png maks. 2MB</small>
    @error('category_icon')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
@isset($category->category_icon)
    <label class="col-form-label">Icon Sekarang</label>
    <img src="{{ asset($category->category_icon) }}" alt="{{ $category->category_name ?? 'Icon' }}" class="img-fluid rounded mt-0 mb-3">
@endisset
<button type="submit" class="btn btn-block btn-primary">Simpan Perubahan</button>
