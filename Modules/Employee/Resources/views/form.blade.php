<div class="form-group">
    <label for="employee_name">Nama Karyawan</label>
    <input type="text" class="form-control @error('employee_name') is-invalid @enderror" name="employee_name" id="employee_name" value="{{ $employee->employee_name ?? old('employee_name') }}" required autofocus autocomplete="name">
    @error('employee_name')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="employee_position">Posisi/Jabatan Karyawan</label>
    <input type="text" class="form-control @error('employee_position') is-invalid @enderror" name="employee_position" id="employee_position" value="{{ $employee->employee_position ?? old('employee_position') }}" required>
    @error('employee_position')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="employee_phone">Nomor Telepon/WhatsApp (WA)</label>
    <input type="tel" class="form-control @error('employee_phone') is-invalid @enderror" name="employee_phone" id="employee_phone" value="{{ $employee->employee_phone ?? old('employee_phone') }}" required autocomplete="phone" aria-describedby="helpEmployeePhone">
    <small id="helpEmployeePhone" class="form-text text-muted">Contoh: 62812xxx</small>
    @error('employee_phone')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="email">Email Login</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ $employee->relatedUser->email ?? old('email') }}" required autocomplete="email">
    @error('email')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="employee_address">Alamat Lengkap</label>
    <textarea rows="5" class="form-control @error('employee_address') is-invalid @enderror" name="employee_address" id="employee_address" required>{{ $employee->employee_address ?? old('employee_address') }}</textarea>
    @error('employee_address')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<button type="submit" class="btn btn-block btn-primary">Simpan Perubahan</button>
