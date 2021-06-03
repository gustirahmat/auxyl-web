<div class="form-group">
    <label for="supplier_name">Nama Supplier</label>
    <input type="text" class="form-control @error('supplier_name') is-invalid @enderror" name="supplier_name" id="supplier_name" value="{{ $supplier->supplier_name ?? old('supplier_name') }}" required autofocus autocomplete="name">
    @error('supplier_name')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="supplier_phone">Nomor Telepon/WhatsApp (WA)</label>
    <input type="text" class="form-control @error('supplier_phone') is-invalid @enderror" name="supplier_phone" id="supplier_phone" value="{{ $supplier->supplier_phone ?? old('supplier_phone') }}" required autocomplete="phone" aria-describedby="helpSupplierPhone">
    <small id="helpSupplierPhone" class="form-text text-muted">Contoh: 62812xxx</small>
    @error('supplier_phone')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="supplier_address">Alamat Lengkap</label>
    <textarea rows="5" class="form-control @error('supplier_address') is-invalid @enderror" name="supplier_address" id="supplier_address" required>{{ $supplier->supplier_address ?? old('supplier_address') }}</textarea>
    @error('supplier_address')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<button type="submit" class="btn btn-block btn-primary">Simpan Perubahan</button>
