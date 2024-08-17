@extends('layouts.dashboard')

@section('dashboard-content')
<link rel="stylesheet" href="{{ $css }}">
<div class="container">
    <h1>Edit Proker</h1>
    <form action="{{ route('proker.update', $proker->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="divisi">Divisi</label>
            <select name="divisi" id="divisi" class="form-control">
                <option value="pendidikan" {{ $proker->divisi == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                <option value="litbang" {{ $proker->divisi == 'litbang' ? 'selected' : '' }}>Litbang</option>
                <option value="kominfo" {{ $proker->divisi == 'kominfo' ? 'selected' : '' }}>Kominfo</option>
                <option value="rsdm" {{ $proker->divisi == 'rsdm' ? 'selected' : '' }}>RSDM</option>
            </select>
        </div>

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $proker->title) }}" required>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control" rows="4" required>{{ old('content', $proker->content) }}</textarea>
        </div>

        <div class="form-group">
            <label for="fotokegiatan">Foto Kegiatan</label>
            <input type="file" name="fotokegiatan[]" id="fotokegiatan" class="form-control" multiple>

            @if($proker->fotokegiatan)
            <div class="mt-3">
                <h5>Foto yang Ada:</h5>
                <div class="row">
                    @foreach(explode(',', $proker->fotokegiatan) as $foto)
                    <div class="col-md-3 mb-3">
                        <img src="{{ asset('assets/divisi/kegiatan-divisi/' . $foto) }}" class="img-fluid deleteable-photo" alt="{{ $foto }}" data-foto="{{ $foto }}">
                        <div class="form-check">
                            <input type="checkbox" name="delete_images[]" value="{{ $foto }}" class="form-check-input delete-checkbox" id="delete_{{ $foto }}">
                            <label class="form-check-label" for="delete_{{ $foto }}">Hapus</label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.deleteable-photo').forEach(function(photo) {
            photo.addEventListener('click', function() {
                const fotoName = this.getAttribute('data-foto');
                const checkbox = document.querySelector(`.delete-checkbox[value="${fotoName}"]`);
                checkbox.checked = !checkbox.checked; // Toggle the checkbox
            });
        });
    });
</script>
@endsection
@endsection
