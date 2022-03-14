@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Task Edit</h4>
            </div>
            <div class="panel-body">
                <form action="{{url('task_update', $data->id)}}" method="post">
                    <!-- <input type="hidden" name="id" id="id" value="{{$data->id}}"> -->
                    <div class="form-group">
                        <label for="nama">Username</label>
                        <input type="text" name="created_by" id="created_by" class="form-control" readonly="readonly" value="{{$data->created_by}}" required="require">
                    </div>

                    <div class="form-group">
                        <label for="judul">Task Title</label>
                        <input type="text" name="task_title" id="task_title" value="{{$data->task_title}}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="pet-select">Task Status:</label>

                        <select name="task_status" id="task_status" required="require">
                        <option value="{{$data->task_status}}">Status Sebelumnya -> <?php echo $data->task_status; ?></option>
                            <option value="waiting">Waiting</option>
                            <option value="progress">Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pet-select">Task Level Priority:</label>

                        <select name="task_priority" id="task_priority">
                            <option value="{{$data->task_priority}}">Priority Sebelumnya -> <?php echo $data->task_priority; ?></option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="isi">Description</label>
                        <textarea rows="15" id="task_message" name="task_message" class="form-control" value=""><?php echo $data->task_message; ?></textarea>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="send" id="send" value="Simpan" class="btn btn-success">{!!csrf_field()!!}
                        <a href="{{url('list')}}" class="btn btn-md btn-warning">Batal</a>
                    </div>
            </div>
        </div>
    </div>
@endsection