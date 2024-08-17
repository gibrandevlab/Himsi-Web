@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container">
        <h1>Proker</h1>
        <a href="{{ route('proker.create') }}" class="btn btn-primary">Tambah Proker</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Divisi</th>
                    <th>title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prokers as $index => $proker)
                    <tr>
                        <td>{{ $index + 1 }}</td> <!-- Adjusted to use $index -->
                        <td>{{ $proker->divisi }}</td>
                        <td>{{ $proker->title }}</td>
                        <td>
                            <a href="{{ route('proker.edit', $proker->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('proker.destroy', $proker->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
