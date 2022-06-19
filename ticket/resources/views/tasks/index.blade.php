@extends('layouts.app')

@section('content')

@if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif

<div id="tree">
  <ul>
    @foreach ($tasks as $task)
      <li id="{{$task->id}}"> {{ $task->isRoot() ? $task->title : ''}}
        <ul>
          @foreach ($task->children as $child)
          <li id="{{$child->id}}">{{$child->title}}</li>
          @endforeach
        </ul>  
    @endforeach
    </li>
  </ul>


</div>

<button>button</button>


<script>
  const jsTreeElement = $('#tree');
  jsTreeElement.jstree()
  jsTreeElement.on('changed.jstree', function(e, node) {
    console.log(node.selected) 
  })

  $('button').on('click', function (data) {
    const NODEID = "12"
    jsTreeElement.jstree('select_node', NODEID)
  })

</script>

 




@endsection


