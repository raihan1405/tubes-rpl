@extends('layout.master')

@section('content')
<form action="/menu" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
      <label>Nama</label>
      <input type="text" name="nama" class="form-control">
    </div>
    @error('nama')
        <div class="alert alert-danger">{{$message}}</div>
    @enderror
    <div class="form-group">
        <label>Harga</label>
        <input type="text" name="harga" class="form-control">
    </div>
      @error('harga')
          <div class="alert alert-danger">{{$message}}</div>
      @enderror
    <div class="form-group">
        <label>Gambar</label>
        <input type="file" name="gambar" class="form-control">
    </div>
      @error('gambar')
          <div class="alert alert-danger">{{$message}}</div>
      @enderror
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection