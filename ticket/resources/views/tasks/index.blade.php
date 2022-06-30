@extends('layouts.app')

@section('content')

{{-- @include('layouts.filter')  --}}

@php
    function printLabelPriority($priorityLevel) {
      
      switch ($priorityLevel) {
        case 'high':
          return '<span class="label label-danger ms-2">🔥 High</span>';
          break;
        case 'medium':
          return '<span class="label label-warning ms-2">💫 Medium</span>';
          break;
        case 'low':
          return '<span class="label label-success ms-2">🌵 Low</span>';
          break;
        default:
          return '<span class="label label-primary ms-2">Default</span>';
          break;
      }
    };


    function printStatusLevel($statusLevel) {
      
      switch ($statusLevel) {
        case 'waiting':
          return '<span class="label label-default ms-2">⏳ Waiting</span>';
          break;
        case 'progress':
          return '<span class="label label-warning ms-2">🏃 Progress</span>';
          break;
        case 'done':
          return '<span class="label label-success ms-2">🎉 Done</span>';
          break;
        default:
          return '<span class="label label-primary ms-2">Default</span>';
          break;
      }
    };


    function getTicket($ticket_id) {
      $ticket = App\Ticket::find($ticket_id); 
      if (isset($ticket->priority)) {
        return $ticket;
      }
    }

    function getTicketId($tickets, $ticket_id = null) {
      
      foreach ($tickets as $ticket) {
        if ($ticket->id === $ticket_id) {
          return $ticket;
        }
      }
      
    }
@endphp

{{-- Filter --}}
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
{{-- End Filter --}}

<script>
  
  $('.datepicker').datepicker({
    todayBtn: true,
    todayBtn: "linked",
    todayHighlight: true
  });

  function setNameAttr(inputElem, nameValue) {
    inputElem.setAttribute("name", nameValue);
  }

</script>



{{-- <script>
  $(document).ready(function() {
  $("#success-alert").hide();
  $("#myWish").click(function showAlert() {
    $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
      $("#success-alert").slideUp(500);
    });
  });
});
</script> --}}

<div class="container">

  @if (\Session::has('success'))
  <div class="row justify-content-center">
    <div class="col-md-6 ">

      <div class="alert alert-success mt-2" id="myAlert">
        <button type="button" class="close" data-dismiss="alert">❌</button>
        <p class="text-center">
          <strong>{!! \Session::get('success') !!}</strong>
        </p>  
      </div>

    </div>
  </div>
  @endif

  <div class="row mb-5">

    <div class="col-2">
      <form action="{{ route('tasks.add') }}" method="GET">
        <button class="btn btn-success btn-sm">New Task</button>
      </form>
    </div>
    
  </div>

  <div class="row">

      <div id="tree">

        <ul>
            <li id="{{ $root['id'] }}" data-jstree='{"opened":true}'> {{ $root['title'] }} 
              @php
                  function getUserId($id) {
                    $userId = App\TaskNode::find($id)->ticket;
                    return $userId;
                  };

                  function getUsername($nodeId) {
                    $userId = getUserId($nodeId)['user_id'];
                    try {
                      $user = App\User::findOrFail($userId);
                      return $user['username'];
                    } catch (Exception $e){
                      return false;
                    }
                  
                    
                  };

              @endphp
              <ul>
                @if (count($childrens))
                @foreach ($childrens as $child)
                <li class="mt-2 col" id={{$child->id}}>{{$child->title}} <small class="text-muted"><em> {{ getUsername($child->id) }}</em></small>
      
                  @php
                    $childTicketId = $child->ticket_id;
                    $ticket = getTicketId($tickets, $childTicketId);
                    $priority = isset($ticket['priority']) ? $ticket['priority'] : null;
                    
                    echo printLabelPriority($priority);   
                    
                    $status = isset($ticket['status']) ? $ticket['status'] : null ;
                    echo printStatusLevel($status); 

                    $csrf_token = csrf_token();
                    echo "<span class='float-end ms-3'><form class='delete-btn' onclick='deleteNode(this)' id='delete-$child->id' action='/tasks/$child->id' method='POST'>
                      {!! method_field('delete') !!}
                      {!! csrf_field() !!}    
                      <input type='hidden' name='_method' value='delete' />
                      <input type='hidden' name='_token' value='$csrf_token'/>
                      <button type='submit' style='padding: 2px 5px;' id='deleteButton' onclick='return confirm('Are You Sure Want to Delete?');' class='btn btn-danger btn-sm'>
                        <i class='bi bi-trash'></i>  
                      </button>
                      </form>
                      </span>";

                      echo "<span class='float-end ms-5'><form class='edit-form' onclick=submit() id='delete-$child->id' action='/tasks/$child->id/edit' method='GET'>
                      <button type='submit' style='padding: 2px 5px ;' id='editButton' class='btn btn-primary btn-sm'>
                        <i class='bi bi-pencil'></i>
                      </button>
                      </form>
                      </span>";
                  @endphp
                @endforeach
                @endif

              </ul>

          </li>
        </ul>
  
      </div>

 
  </div>

</div>


<script>
  const jsTreeElement = $('#tree');
  const deleteButton = $('#deleteButton');
  const deleteForm = $('#deleteForm');

  jsTreeElement.jstree({
    "core" : {
    "themes" : {
      "variant" : "large"
    },
  },
  // "checkbox" : {
  //   "keep_selected_style" : false
  // },
  // "plugins" : [ "wholerow", "checkbox" ]
  })
  
  jsTreeElement.on('changed.jstree', function(e, node) {
    // console.log(node.selected) 
    // deleteButton.prop("disabled", false)
    // deleteForm.prop("action", `/tasks/${node.selected}`);
    
  })

  $('#deleteButton').on('click', function () {

    
  })

  // $('button').on('click', function (data) {
  //   const NODEID = "12"
  //   jsTreeElement.jstree('select_node', NODEID)
  // })

  function deleteNode(thisForm) {
    if (confirm('Are You Sure Want to Delete?')) {
      thisForm.submit();
    } 
  }

</script>

 
@endsection