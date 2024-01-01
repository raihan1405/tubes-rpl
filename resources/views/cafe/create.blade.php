@extends('admin.dashboard')

@section('judulAdmin')
Tambah Cafe
@endsection

@section('contentAdmin')
<form action="/cafe" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label>Nama</label>
      <input type="text" name="nama" class="form-control">
    </div>
    @error('nama')
        <div class="alert alert-danger">{{$message}}</div>
    @enderror
    <div class="form-group">
        <label>Alamat</label>
        <input type="text" name="alamat" class="form-control">
    </div>
      @error('alamat')
          <div class="alert alert-danger">{{$message}}</div>
      @enderror
    <div class="form-group">
        <label>Gambar</label>
        <input type="file" name="gambar" class="form-control">
    </div>
      @error('gambar')
          <div class="alert alert-danger">{{$message}}</div>
      @enderror
    <div class="form-group">
        <label>Deskripsi</label>
        <input type="content" name="content" class="form-control">
    </div>
      @error('content')
          <div class="alert alert-danger">{{$message}}</div>
      @enderror
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection