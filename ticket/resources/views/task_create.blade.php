@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Task Create</h4>
            </div>
            <div class="panel-body">
                <form action="{{url('task_insert')}}" method="post">

                    <div class="form-group">
                        <label for="nama">Name</label>
                        <input type="text" name="nama" id="created_by" class="form-control" readonly="readonly" value="{{ Auth::user()->username }}" required="require">
                    </div>

                    <div class="form-group">
                        <label for="judul">Task Title</label>
                        <input type="text" name="task_title" id="task_title" class="form-control" required="require">
                    </div>

                    <div class="form-group">
                        <label for="pet-select">Choose Level Priority:</label>

                        <select name="task_priority" id="task_priority" required="require">
                            <option value="">--Please choose an option--</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pet-select">Status Task:</label>

                        <select name="task_status" id="task_status" required="require">
                            <option value="waiting">Waiting</option>
                            <option value="progress">Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="priority">Description</label>
                        <textarea id="task_message" name="task_message" class="form-control" rows="15" required="require"></textarea>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="send" id="send" value="Simpan" class="btn btn-success">{!!csrf_field()!!}
                        <a href="{{url('task')}}" class="btn btn-md btn-warning">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection