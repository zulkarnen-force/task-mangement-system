<!DOCTYPE html>
<html>

@if(Session::has('alert'))
<div class="alert alert-success">
    <strong>{{ Session::get('alert')}}<strong>
</div>
@endif

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
            <div class="panel-heading" style="background-color:powderblue;">

                <!-- Scripts -->

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        Welcome ({{ Auth::user()->username }}) your privilage as ({{ Auth::user()->type }}) <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{ url('/logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>

                <script src="/js/app.js"></script>

                <!-- Scripts -->

                <h4>Kolom Komentar :</h4>
            </div>

            @foreach($data as $key => $d)
            <div class="panel-heading">
                <table class="table table-striped">
                    <thead>
                        <div class='media-body'>
                            <strong class='name_komentar'>{{ $d->name_komentar }}</strong> <i>mengatakan:</i>
                            <br>
                            {{ $d->message_komentar }}</br>
                        </div>
                    </thead>

                    @endforeach

                    </tbody>
                </table>

            </div>

            <div class="panel-heading" style="background-color:powderblue;">
                <h4>Kolom Pengisian :</h4>
            </div>

            <div class="panel-body">
                <form action="{{url('posting')}}" method="post">

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
                        <a href="{{url('list')}}" class="btn btn-md btn-warning">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

<!-- scroll to top -->

<div>
<button style="position: fixed; bottom: 20px; right: 30px; font-size: 10px;" class="btn btn-md btn-info" onclick="scroll_top()" id="tombolNya" title="Kembali ke atas halaman">TOP</button>
</div>
<script>

window.onscroll = function() {fungsiScrollnya()};
// bagian scrollTop setting brp pixel turun keluar button topnya
function fungsiScrollnya() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("tombolNya").style.display = "block";
    } else {
        document.getElementById("tombolNya").style.display = "none";
    }
}

function scroll_top() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0; // 0 untuk kembali kepaling atas halaman, ubah jikalau perlu
}
</script>

<!-- scroll to top -->

</html>