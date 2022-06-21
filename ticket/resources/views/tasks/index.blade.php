@extends('layouts.app')

@section('content')

@php
    function printLabelPriority($priorityLevel) {
      
      switch ($priorityLevel) {
        case 'high':
          return '<span class="label label-danger ms-2">🔥 High</span>';
          break;
        case 'medium':
          return '<span class="label label-warning ms-2">Medium</span>';
          break;
        case 'low':
          return '<span class="label label-success ms-2">Low</span>';
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





@if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif

<div class="container">


  <div class="row mb-5">
    

    <div class="col-2">
      <form  id="deleteForm" method="POST">
        {!! method_field('delete') !!}
        {!! csrf_field() !!}    
        <button type="submit" id="deleteButton" onclick="return confirm('Are You Sure Want to Delete?');" disabled class="btn btn-danger btn-sm">⌫</button>
      </form>
    </div>

    <div class="col-2">
      <form action="{{route('tasks.add')}}" method="GET">
        <button class="btn btn-success btn-sm">Add</button>
      </form>
    </div>
    

  </div>

  <div class="row">

    <div id="tree">

      <ul>
        @foreach ($tasks as $task)
          <li id="{{$task->id}}"> {{ $task->isRoot() ? $task->title : ''}}
            <ul>
              @foreach ($task->children as $child)
              <li class="mt-2 col" id={{$child->id}}>{{$child->title}} <small>Username</small>
    
                @php
    
                  $childTicketId = $child->ticket_id;
                  $ticket = getTicketId($tickets, $childTicketId);
                  
                  $priority = isset($ticket['priority']) ? $ticket['priority'] : null;
                  echo printLabelPriority($priority);   
    
                  $status = isset($ticket['status']) ? $ticket['status'] : null ;
                  echo printStatusLevel($status);   
    
                @endphp
              @endforeach
            </ul>
        @endforeach
        </li>
      </ul>

    </div>


  </div>

</div>





<script>
  const jsTreeElement = $('#tree');
  const deleteButton = $('#deleteButton');
  const deleteForm = $('#deleteForm');

  jsTreeElement.jstree()
  jsTreeElement.on('changed.jstree', function(e, node) {
    console.log(node.selected) 
    deleteButton.prop("disabled", false)
    deleteForm.prop("action", `/tasks/${node.selected}`);
  })

  $('#deleteButton').on('click', function () {

    
  })

  // $('button').on('click', function (data) {
  //   const NODEID = "12"
  //   jsTreeElement.jstree('select_node', NODEID)
    
  // })

</script>

 




@endsection


