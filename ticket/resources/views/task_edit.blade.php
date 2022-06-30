@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">


    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Task Edit</h4>
            </div>
            <div class="panel-body">
                <form action="{{ route('tasks.update', $id) }}" method="post">
                    {{ method_field('PUT') }}
                    {{-- <!-- <input type="hidden" name="id" id="id" value="{{$ticket->id}}"> --> --}}
                    <div class="form-group">
                        <label for="nama">Username</label>
                        <input type="text" name="username" id="username" class="form-control" readonly="readonly" value="{{$user->username}}" required="require">
                    </div>

                    <div class="form-group">
                        <label for="judul">Task Title</label>
                        <input type="text" name="title" id="title" value="{{$ticket->title}}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="pet-select">Task Status:</label>

                        <select name="status" id="status" required="require">
                        <option value="{{$ticket->status}}">Status Sebelumnya -> <?php echo $ticket->status; ?></option>
                            <option value="waiting">Waiting</option>
                            <option value="progress">Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pet-select">Task Level Priority:</label>

                        <select name="priority" id="priority">
                            <option value="{{ $ticket->priority }}">Priority Sebelumnya -> <?php echo $ticket->priority; ?></option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="isi">Description</label>
                        <textarea rows="15" id="message" name="message" class="form-control" value=""><?php echo $ticket->message; ?></textarea>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="send" id="send" value="Simpan" class="btn btn-success">{!!csrf_field()!!}
                        <a href="{{ url('list') }}" class="btn btn-md btn-warning">Batal</a>
                    </div>
            </div>
        </div>
    </div>
@endsection