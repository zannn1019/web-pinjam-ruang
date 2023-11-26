@if ($errors->any())
    <div style="display:  flex; flex-direction: column; gap: 10px">
        @foreach ($errors->all() as $index => $error)
            <span style="display: inline-block; border: 1px solid red; padding: 10px;">{{ $error }}</span>
        @endforeach
    </div>
@endif
<form action="{{ route('userPinjamRuang') }}" method="post"
    style="display: flex; flex-direction: column; align-items: flex-start">
    @csrf
    <label for="nama_peminjam">Nama peminjam</label>
    <input type="text" name="nama_peminjam" id="nama_peminjam" class="form-control" value="{{ old('nama_peminjam') }}"
        required>

    <label for="no_hp_peminjam">No hp peminjam</label>
    <input type="text" name="no_hp_peminjam" id="no_hp_peminjam" class="form-control"
        value="{{ old('no_hp_peminjam') }}" required minlength="10">

    <label for="jabatan_peminjam">Jabatan peminjam</label>
    <input type="text" name="jabatan_peminjam" id="jabatan_peminjam" class="form-control"
        value="{{ old('jabatan_peminjam') }}" required>

    <label for="fakultas">Fakultas</label>
    <input type="text" name="fakultas" id="fakultas" class="form-control" value="{{ old('fakultas') }}" required>

    <label for="id_ruangan">Pilih ruangan : </label>
    @if ($ruangan->count())
        <select name="id_ruangan" id="id_ruangan" class="form-control" required>
            @foreach ($ruangan as $ruang)
                <option value="{{ $ruang->id }}" {{ old('nama_peminjam') == $ruang->id ? 'selected' : '' }}>
                    {{ $ruang->nama_ruangan }}
                </option>
            @endforeach
        </select>
    @else
        <span>Ruangan kosong tidak tersedia</span>
    @endif

    <label for="nama_kegiatan">Nama kegiatan</label>
    <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control"
        value="{{ old('nama_kegiatan') }}" required>

    <label for="tanggal_mulai_pinjam">Tanggal mulai pinjam</label>
    <input type="datetime-local" name="tanggal_mulai_pinjam" id="tanggal_mulai_pinjam" class="form-control"
        value="{{ old('tanggal_mulai_pinjam') }}" required>

    <label for="tanggal_akhir_pinjam">Tanggal akhir pinjam</label>
    <input type="datetime-local" name="tanggal_akhir_pinjam" id="tanggal_akhir_pinjam" class="form-control"
        value="{{ old('tanggal_akhir_pinjam') }}" required>

    <label for="penanggung_jawab">Penanggung jawab</label>
    <input type="text" name="penanggung_jawab" id="penanggung_jawab" class="form-control"
        value="{{ old('penanggung_jawab') }}" required>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
<a href="/admin">Admin Login</a>
