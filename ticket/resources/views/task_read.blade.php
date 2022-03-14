@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">

<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Task Read</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="kode">Username</label>
                    <input type="text" name="created_by" id="created_by" value="{{$data->created_by}}" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="judul">Task Title</label>
                    <input type="text" name="task_title" id="task_title" value="{{$data->task_title}}" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <input type="text" name="task_status" id="task_status" value="{{$data->task_status}}" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="priority">Priority</label>
                    <input type="text" name="task_priority" id="task_priority" value="{{$data->task_priority}}" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="desk">Description</label>
                    <textarea rows="20" class="form-control" input type="text" readonly="readonly" name="task_message" id="task_message" value=""><?php echo $data->task_message; ?></textarea>
                </div>
                <a href="{{url('task')}}" class="btn btn-md btn-warning">Kembali</a>
            </div>
        </div>
    </div>
</body>

@endsection