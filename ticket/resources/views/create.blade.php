@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Create Ticket</h4>
            </div>
            <div class="panel-body">
                <form action="{{url('insert')}}" method="post">

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" required="require" maxlength="35" style="width: 250px;">
                    </div>

                    <!-- <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control" required="require">
                    </div> -->

                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <input type="text" name="judul" id="judul" class="form-control" required="require" maxlength="70" style="width: 545px;">
                    </div>

                    <div class="form-group">
                        <label for="pet-select">Pilih Level Priority:</label>

                        <select name="priority" id="priority" required="require">
                            <option value="">--Please choose an option--</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>

                    @if (Auth::user()->type == 'root')
                    <div class="form-group">
                        <label for="pet-select">Status Ticket:</label>

                        <select name="status" id="status" required="require">
                            <option value="waiting">Waiting</option>
                            <option value="progress">Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>

                    @else

                    <div class="form-group">
                        <label for="pet-select">Status Ticket:</label>

                        <select name="status" id="status" required="require">
                            <option value="waiting">Waiting</option>
                        </select>
                    </div>

                    @endif

                    <div class="form-group">
                        <label for="priority">Deskripsi</label>
                        <textarea id="isi" name="isi" class="form-control" required="require" rows="10"></textarea>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="send" id="send" value="Simpan" class="btn btn-success">{!!csrf_field()!!}
                        <a href="{{url('list')}}" class="btn btn-md btn-warning">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection