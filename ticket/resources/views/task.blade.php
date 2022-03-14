@extends('layouts.app')

@section('content')
<!-- MAIN -->

<div class="container">
    <div class="panel panel-default" style="width: 120%; margin-left: -100px; margin-top: 50px;">
        <div class="panel-heading">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 100px;">Id</th>
                        <th style="width: 120px;">Created By</th>
                        <th style="width: 120px;">Task</th>
                        <th style="width: 200px;">Description</th>
                        <th style="width: 120px;">Priorty</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 200px;">Created Date</th>
                        <th style="width: 200px;">Modifed Date</th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                </thead>

                @foreach($data as $key => $d)

                <!-- listing task -->
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->created_by }}</td>
                    <td>{{ $d->task_title }}</td>
                    <td>
                        <div style="white-space: nowrap; width: 200px; overflow: hidden; text-overflow: ellipsis;">{{ $d->task_message }}</div>
                    </td>
                    <td>{{ $d->task_priority }}</td>
                    <td>{{ $d->task_status }}</td>
                    <td>{{ date("d F Y h:m:s", strtotime($d->c_date))}}</td>
                    <td>{{ date("d F Y h:m:s", strtotime($d->m_date))}}</td>
                    <td>
                        <a href="{{url('task_delete',array($d->id))}}" onclick="return confirm('Anda yakin mau menghapus ticket ini ?')">Delete</a>
                        <span>|</span>
                        <a href="{{url('task_edit',array($d->id))}}">Edit</a>
                        <span>|</span>
                        <a href="{{url('task_read',array($d->id))}}">Read Task</a>
                    </td>
                </tr>

                <!-- Penutup listing task -->

                @endforeach

            </table>
        </div>
    </div>
</div>

@endsection