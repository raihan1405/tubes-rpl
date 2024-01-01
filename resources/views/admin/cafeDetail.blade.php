@extends('admin.dashboard')

@section('judulAdmin')
    Halaman Detail Cafe

@endsection

@section('contentAdmin')
<table class="table">
    <thead>
      <tr>
        <th scope="col">Nama</th>
        <th scope="col">Alamat</th>
        <th scope="col">Content</th>
        <th scope="col">Gambar</th>
      </tr>
    </thead>
    <tbody>
            <tr>
                <td>{{$cafe->nama}}</td>
                <td>{{$cafe->alamat}}</td>
                <td>{{$cafe->content}}</td>
                <td><a href="{{asset('image/' . $cafe->gambar)}}">{{$cafe->gambar}}</a></td>
    
            </tr>
    </tbody>
    <thead>
        <tr>
          <th scope="col">Komentar</th>
          <th scope="col">Rating</th>
          <th scope="col">Created_at</th>
          <th scope="col">user_id</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($reviews as $key=>$value)
        <tr>
            <td>{{ $value->komentar }}</td>
            <td>
                <?php
                $count = 0;
                while ($count < $value->rating) {
                    echo '<span>&#9733;</span>';
                    $count++;
                }
                ?>
            </td>
            <td>{{ $value->created_at }}</td>
            <td>{{ $value->user_id }}</td>
            
            
        </tr>
    @empty
        <p>No reviews</p>
    @endforelse
    

</tbody>
  </table>
@endsection