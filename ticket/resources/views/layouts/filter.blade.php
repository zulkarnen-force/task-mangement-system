<div class="container" id="filter">

    <div id="collapse"> {{-- collapse   action="/tasks/filter"--}}
        <form id="form-filter" action="{{ route('tasks.filter') }}" method="post">
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
                <button type="submit" id="apply" class="btn btn-primary mt-4 btn-sm float-end">Apply ✔</button>
            </div>

        </form>
    </div>
    
    {{-- <button class="btn btn-danger mt-4 btn-sm" data-bs-toggle="collapse" data-bs-target="#collapse">Filters</button> --}}


</div>

<script>


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

function setAction() {
    const pathName = window.location.pathname;
    const formFilterElem = $('#form-filter')
    formFilterElem.setAttribute('action', `/tests/${pathName}`);
}


</script>