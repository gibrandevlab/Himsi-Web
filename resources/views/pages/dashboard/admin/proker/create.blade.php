@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container">
        <h1>Tambah Proker</h1>
        <form action="{{ route('proker.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="divisi">Divisi</label>
                <select name="divisi" id="divisi" class="form-control">
                    <option value="pendidikan">Pendidikan</option>
                    <option value="litbang">Litbang</option>
                    <option value="kominfo">Kominfo</option>
                    <option value="rsdm">RSDM</option>
                </select>
            </div>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="fotokegiatan">Foto Kegiatan</label>
                <input type="file" name="fotokegiatan[]" id="fotokegiatan" class="form-control" multiple required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
