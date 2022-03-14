@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 120px; margin-left: 350px;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>ADMIN PANEL</h4>
        </div>
        <div class="panel-body">
            <form action="{{url('register')}}" method="get">
                <div class="form-group">
                    <input type="submit" name="bikin" id="bikin" value="Bikin Akun" class="btn btn-success">
                    <!-- <a href="{{url('list')}}" class="btn btn-md btn-warning">Kembali</a> -->
                </div>
            </form>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Username</th>
                        <th>TYPE</th>
                        <th>Tanggal Dibuat</th>
                        <th>Tanggal Diubah</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($data as $key => $d)
                    <tr>
                        <td>{{ $d->id }}</td>
                        <td>{{ $d->username }}</td>
                        <td>{{ $d->type }}</td>
                        <td>{{ date("d F Y h:m:s", strtotime($d->created_at))}}</td>
                        <td>{{ date("d F Y h:m:s", strtotime($d->updated_at))}}</td>
                        <td>
                            <a href="{{url('Usrdelete',array($d->id))}}" onclick="return confirm('Anda yakin mau menghapus Akun ini ?')">Delete</a>
                            <span>|</span>
                            <a href="{{url('Usredit',array($d->id))}}">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection