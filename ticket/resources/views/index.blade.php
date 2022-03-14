@extends('layouts.app')

@section('content')
<!-- MAIN -->

<div class="container">
    <div class="panel panel-default" style="width: 120%; margin-left: -100px; margin-top: 30px;">
        <div class="panel-heading">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th style="width: 120px;">Nama</th>
                        <th>Judul</th>
                        <th>Priority</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Dibuat</th>
                        <th>Tanggal Diubah</th>
                        <th>Status</th>
                        <th style="width: 90px;">User Insert</th>
                        <th style="width: 200px;">Action</th>
                    </tr>
                </thead>

                @foreach($data as $key => $d)

                @if ($d->created_by == Auth::user()->username)
                <!-- listing ticket per username -->
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->name }}</td>
                    <td>{{ $d->tittle }}</td>
                    <td>{{ $d->priority }}</td>
                    <td>
                        <div style="white-space: nowrap; width: 200px; overflow: hidden; text-overflow: ellipsis;">{{ $d->message }}</div>
                    </td>
                    <td>{{ date("d F Y h:m:s", strtotime($d->c_date))}}</td>
                    <td>{{ date("d F Y h:m:s", strtotime($d->m_date))}}</td>
                    <td>{{ $d->status }}</td>
                    <td>{{ $d->created_by }}</td>
                    <td>
                        <a href="{{url('read',array($d->id))}}">Read & Comment</a>
                        <span>|</span>
                        @if (Auth::user()->type == 'root')
                        <a href="{{url('delete',array($d->id))}}" onclick="return confirm('Anda yakin mau menghapus ticket ini ?')">Delete</a>
                        <span>|</span>
                        @endif
                        <a href="{{url('edit',array($d->id))}}">Edit</a>
                    </td>
                </tr>

                @else
                <!-- listing khusus type root all akses -->

                @if(Auth::user()->type == 'root')
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->name }}</td>
                    <td>{{ $d->tittle }}</td>
                    <td>{{ $d->priority }}</td>
                    <td>
                        <div style="white-space: nowrap; width: 200px; overflow: hidden; text-overflow: ellipsis;">{{ $d->message }}</div>
                    </td>
                    <td>{{ date("d F Y h:m:s", strtotime($d->c_date))}}</td>
                    <td>{{ date("d F Y h:m:s", strtotime($d->m_date))}}</td>
                    <td>{{ $d->status }}</td>
                    <td>{{ $d->created_by }}</td>
                    <td>
                        <a href="{{url('read',array($d->id))}}">Read & Comment</a>
                        <span>|</span>
                        @if (Auth::user()->type == 'root')
                        <a href="{{url('delete',array($d->id))}}" onclick="return confirm('Anda yakin mau menghapus ticket ini ?')">Delete</a>
                        <span>|</span>
                        @endif
                        <a href="{{url('edit',array($d->id))}}">Edit</a>
                        <span>|</span>
                        <a href="{{url('export',array($d->id))}}">Export</a>
                    </td>
                </tr>

                @endif
                <!-- Penutup listing type root -->

                @endif
                <!-- Penutup listing pemisah antar user -->

                @endforeach

            </table>
        </div>
    </div>
</div>

@endsection