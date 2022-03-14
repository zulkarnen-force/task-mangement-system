<!DOCTYPE html>
<html>

<head>
    <title>Ticket Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
</head>
<br></br>
<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>ADMIN EDIT FORM</h4>
            </div>
            <div class="panel-body">
                <form action="{{url('Usrupdate', $data->id)}}" method="post">

                    <div class="form-group">
                        <label for="username" class="col-md-4 control-label">Username</label>

                        <div class="col-md-6">
                            <input id="username" type="text" class="form-control" name="username" value="{{$data->username}}" required>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="type" class="col-md-4 control-label">Jabatan</label>
                        <div class="col-md-6">
                            <select name="type" class="form-control" required>
                                <option value="{{Auth::user()->type}}">Type Sebelumnya >> <?php echo $data->type;?></option>
                                <option value="root">root</option>
                                <option value="user">user</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="send" id="send" value="Simpan" class="btn btn-success">{!!csrf_field()!!}
                            <a href="{{url('admin')}}" class="btn btn-md btn-warning">Batal</a>
                        </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>