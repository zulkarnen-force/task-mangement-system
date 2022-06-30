@extends('layouts.app')

@section('content')
<!-- MAIN -->

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css"> --}}
{{-- @include('layouts.filter') --}}
<div class="container">
 
    <div class="container mb-4" id="filter" >

        <div class="_collapse" id="collapse">
            <form action="/list/filter" method="post">
                {{ csrf_field() }}
                <div>
                    
                    <div class="row">
    
                        <div class="col-md-4">
                            <label for="priority" class="form-label">Priority</label>
                            <select id="priority" class="form-select" name="priority">
                                <option disabled selected value> -- select an option -- </option>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
    
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" class="form-select" name="status">
                                <option disabled selected hidden> -- select an option -- </option>
                                <option value="progress">Progress</option>
                                <option value="waiting">Waiting</option>
                                <option value="done">Done</option>
                            </select>
                        </div>
    
                        <div class="col-md-4">
                            <label for="user" class="form-label">User</label>
                            <select id="user" class="form-select" name="user">
    
                                <option disabled selected hidden> -- select an option -- </option>
                                @php
                                    $users = App\User::all()
                                @endphp
    
                                @foreach ($users as $user)
                                    <option value="{{$user->username}}">{{$user->username}}</option>
                                @endforeach
                            </select>
                        </div>
    
                    </div>
    
                    <div class="row  mt-3">
    
                        <div class="col-md-2">
                            <label for="date" class="form-label">Create At</label>
                                <div class="input-group date datepicker" data-date-format="yyyy/mm/dd">
                                    <input class="form-control" id="date" onchange="setNameAttr(this, 'created_at')">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                        </div>
    
                        <div class="col-md-2">
                            <label for="date" class="form-label">Updated At</label>
                                <div class="input-group date datepicker" data-date-format="yyyy/mm/dd">
                                    <input class="form-control" id="updatedAt" onchange="setNameAttr(this, 'updated_at')">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                        </div>
    
    
                        <div class="col-md-8">
                            <label for="date" class="form-label">Range</label>
                            <div class="input-group input-daterange datepicker" data-date-format="yyyy/mm/dd">
                                <input type="text" class="form-control" onchange="setNameAttr(this, 'from')">
                                <div class="input-group-addon">to</div>
                                <input type="text" class="form-control" onchange="setNameAttr(this, 'to')">
                            </div>
                        </div>
    
                    </div>
    
                    
    
                </div> {{-- filter  --}}
    
                <div>
                    <button type="submit" class="btn btn-primary mt-4 btn-sm float-end">Apply ✔</button>
                </div>
    
            </form>
        </div>
    </div>

    
    
    {{-- <button class="btn btn-danger mt-4 btn-sm" data-bs-toggle="collapse" data-bs-target="#collapse">Filters</button> --}}

    <div class="panel panel-default" style="width: 120%; margin-left: -100px; margin-top: 30px;">

        <div class="panel-heading">

            <table class="table table-striped" id="example">
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

                @php
                    function userExits($id) : bool {
                        try {
                            $user = App\User::findOrFail($id);
                            return true;
                        } catch (Exception $e) {
                            return false;
                        }
                    }

                    function getUsername($id) : string {
                        return App\User::find($id)['username'];
                    }
                @endphp

                <tbody>
                @foreach($data as $d)

                {{-- @if ($d->created_by == Auth::user()->username) --}}
                <!-- listing ticket per username -->
                
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ userExits($d->user_id) ? getUsername($d->user_id) : 'no user' }}</td>
                    <td>{{ $d->title }}</td>
                    <td>{{ $d->priority }}</td>
                    <td>
                        <div style="white-space: nowrap; width: 200px; overflow: hidden; text-overflow: ellipsis;">{{ $d->message }}</div>
                    </td>
                    <td>{{ date("d F Y h:m:s", strtotime($d->created_at))}}</td>
                    <td>{{ date("d F Y h:m:s", strtotime($d->updated_at))}}</td>
                    <td>{{ $d->status }}</td>
                    <td>{{ $d->created_by }}</td>
                    <td>
                        <a href="{{url('read',array($d->id))}}">Read & Comment</a>
                        <span>|</span>
                        {{-- @if (Auth::user()->type == 'root') --}}
                        <a href="{{url('delete',array($d->id))}}" onclick="return confirm('Anda yakin mau menghapus ticket ini ?')">Delete</a>
                        <span>|</span>
                        {{-- @endif --}}
                        <a href="{{url('edit',array($d->id))}}">Edit</a>
                    </td>
                </tr>
                
                {{-- @else --}}
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

                {{-- @endif --}}
                <!-- Penutup listing pemisah antar user -->

                @endforeach
            </tbody>
            </table>
        </div>
    </div>
</div>

<script>

$(document).ready(function () {
    const table = $('#example').DataTable();
 
    $('#example tbody').on('mouseenter', 'td', function () {
        var colIdx = table.cell(this).index().column;
 
        $(table.cells().nodes()).removeClass('highlight');
        $(table.column(colIdx).nodes()).addClass('highlight');
    });
});


$('.datepicker').datepicker({
        todayBtn: true,
        todayBtn: "linked",
        todayHighlight: true
});

$(document).ready(function() {
    $('[data-bs-toggle="collapse"]').click(function () {
        $(this).toggleClass('active');
        if ($(this).hasClass('active')) {
            $(this).text("Hide");
        } else {
            $(this).text("Filters");
        }
    })
});

function setNameAttr(inputElem, nameValue) {
    inputElem.setAttribute("name", nameValue);
}


</script>

@endsection