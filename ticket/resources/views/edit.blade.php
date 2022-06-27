@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Edit</h4>
            </div>
            <div class="panel-body">
                <form action="{{url('update', $data->id)}}" method="post">
                    <!-- <input type="hidden" name="id" id="id" value="{{$data->id}}"> -->
                    @php
                        $user = App\User::find($data->user_id)->get()->first();
                    @endphp

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" disabled id="nama" class="form-control" value="{{$user->username}}" required="require">
                    </div>

                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" name="title" id="title" value="{{$data->title}}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="pet-select">Pilih Level Priority:</label>

                        <select name="priority" id="priority">
                            <option value="{{$data->priority}}">Priority Sebelumnya -> <?php echo $data->priority; ?></option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>

                    @if (Auth::user()->type == 'root')
                    <div class="form-group">
                        <label for="pet-select">Status Ticket:</label>

                        <select name="status" id="status" required="require">
                        <option value="{{$data->status}}">Status Sebelumnya -> <?php echo $data->status; ?></option>
                            <option value="waiting">Waiting</option>
                            <option value="progress">Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>

                    @else

                    <div class="form-group">
                        <label for="pet-select">Status Ticket:</label>

                        <select name="status" id="status" required="require">
                                <option value="{{$data->status}}" selected>{{ $data['status'] }}</option>
                                <option value="waiting">Waiting</option>
                                <option value="progress">Progress</option>
                                <option value="done">Done</option>
                            </select>
                        </select>
                    </div>

                    @endif

                    <div class="form-group">
                        <label for="message">Deskripsi</label>
                        <textarea rows="15" id="message" name="message" class="form-control" value=""><?php echo $data->message; ?></textarea>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="send" id="send" value="Simpan" class="btn btn-success">{!!csrf_field()!!}
                        <a href="{{url('list')}}" class="btn btn-md btn-warning">Batal</a>
                    </div>
            </div>
        </div>
    </div>
@endsection