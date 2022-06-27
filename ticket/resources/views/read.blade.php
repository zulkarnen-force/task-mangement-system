@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">

<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Read & Comment</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ App\User::find($tickets['user_id'])['username'] }}" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" name="judul" id="judul" value="{{ $tickets->title }}" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="desk">Deskripsi</label>

                    <!-- <div -->
                    <textarea rows="20" class="form-control" input type="text" readonly="readonly" name="isi" id="isi" value=""><?php echo $tickets->message; ?></textarea>
                    <!-- <input type="text" name="isi" id="isi" value="{{ $tickets->message }}" class="form-control" readonly> -->
                    <!-- </div> -->

                </div>
                <!-- <a href="{{url('list')}}" class="btn btn-md btn-warning">Kembali</a> -->
            </div>
        </div>
    </div>
</body>

<!-- kolom komentar -->

<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color:powderblue;">

                <h4>Kolom Komentar :</h4>
            </div>

            {{-- @foreach($data_komentar as $key => $d)

            <div class="panel-heading">
                <table class="table table-striped">
                    <tbody>
                        <thead>
                            <div class='media-body'>
                                <strong class='name_komentar'>{{ $d->name_komentar }}</strong> <i>posted on {{ $d->created_date_komentar }} </i>:
                                <br></br>
                                @if (strlen($d->message_komentar) > 50)
                                <div style="  border: none;
                                              border-radius: 6em;
                                              box-shadow: 9px 2px 9px rgba(0,0,0,0.2);
                                              display: inline-block;
                                              font-size: 1em;
                                              padding: 0.7em 2em;
                                              background-color: powderblue;
                                              color: black !important;
                                              width: 47%;
                                              overflow-wrap: break-word;">

                                    {{ $d->message_komentar }}

                                </div>
                                @else
                                <div style="  border: none;
                                              border-radius: 6em;
                                              box-shadow: 9px 2px 9px rgba(0,0,0,0.2);
                                              display: inline-block;
                                              font-size: 1em;
                                              padding: 0.7em 1em;
                                              width: auto;
                                              background-color: powderblue;
                                              color: black !important;">

                                    {{ $d->message_komentar }}

                                </div>
                                @endif
                            </div>
                        </thead>
                    </tbody>
                </table>
            </div>

            @endforeach --}}
            <div class="panel-heading" style="background-color:powderblue;">
                <h4>Kolom Pengisian :</h4>
            </div>

            <div class="panel-body">
                <form action="{{url('posting')}}" method="post">

                    <input style="width: 110px;" maxlength="10" type="text" name="id_ticket" id="id_ticket" value="{{$tickets->id}}" class="hidden">

                    <div class="form-group">
                        <label for="kode">Nama</label>
                        <input style="width: 110px;" maxlength="10" type="text" name="name_komentar" id="name_komentar" class="form-control" required="require">
                    </div>

                    <div class="form-group">
                        <label for="priority">Message</label>
                        <textarea rows="5" id="message_komentar" name="message_komentar" class="form-control" required="require"></textarea>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="posting" id="posting" value="Simpan" class="btn btn-success">
                        <a href="{{url('list')}}" class="btn btn-md btn-warning">Kembali</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

<!-- kolom komentar -->


@endsection