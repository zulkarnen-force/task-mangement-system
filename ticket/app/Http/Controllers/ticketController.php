<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendingEmailTicket;
use App\Mail\sendingEmailTask;
use App\TaskNode;
use App\Ticket;
use App\User;
use DB;
use TaskController;
use Illuminate\Support\Facades\App;
// use File;
// use App\ticket;

// use App\Http\Middleware\Role;
// use Illuminate\Support\Facades\Input;
// use App\User;
// use App\Invoice;
// use Session;
// use Validator;

class ticketController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  // view

  public function index(Request $request)
  {
    $data = $request->session()->all();
    $data = Ticket::get();
    
    return view('index', compact('data'));
  }

  public function back()
  {
    return redirect('list');
  }

  public function create()
  {

    return view('create');
  }

  public function insert(Request $request)
  {
    $data = DB::table('ticket_list')->get();

    $this->validate($request, [
      'nama' => 'required',
    ]);

    $data = [
      'name' => $request->get('nama'),
      'tittle' => $request->get('judul'),
      'priority' => $request->get('priority'),
      'status' => $request->get('status'),
      'message' => $request->get('isi'),
      'created_by' => Auth::user()->username,
    ];

    $email_time = Carbon::now();

    $email = array(
      'name' => $request->nama,
      'tittle' => $request->judul,
      'c_date' => $email_time,
    );

    // dd($email);

    // $email_address = [
      // 'gaptekxricky@gmail.com',
      // 'tulus.winarno@gmail.com',
      // 'greebe91n@gmail.com',
    // ];

    // Mail::to($email_address)->send(new sendingEmailTicket($email));

    $data = DB::table('ticket_list')
      ->insert($data);

    return redirect('list')->with('alert', 'Ticket Berhasil Di Buat');
  }

  public function delete($id)
  {

    $ticket = Ticket::find($id);
    $ticket->task()->delete();
    $ticket->delete();
  
    return redirect('list')->with('alert', 'Ticket Berhasil Di Hapus');

  }

  public function edit($id)
  {
    $data = Ticket::find($id);

    return view('edit', compact('data'));
  }

  public function update(Request $request)
  {
    $ticketId = $request->id;

    $ticket = Ticket::find($ticketId);
    $ticket->update($request->all());

    $taskNode = TaskNode::where('ticket_id', $ticketId);
    $taskNode->update(['title' => $request->get('title')]);

    return redirect('list')->with('alert', 'Ticket berhasil Diubah.');
  }

  public function read(Request $requset, $id)
  {
    $tickets = Ticket::find($id);
    // $data = DB::table('ticket_list')->find($id);
    // $data_komentar = DB::table('komentar')->where('id_ticket', $data->id)->get();

    return view('read', compact('tickets'));
  }

  public function login()
  {
    return view('login');
  }

  public function admin(Request $request)
  {
    $data = $request->session()->all();
    $data = DB::table('users')->paginate();

    return view('admin', compact('data'));
  }

  public function register()
  {

    return view('register');
  }

  // Bagian User

  public function Usrinsert(Request $request)
  {
    $data = [
      'username' => $request->get('username'),
      'type' => $request->get('type'),
      'password' => Hash::make($request['password']),
      'remember_token' => Str::random(60),
    ];
    $data = DB::table('users')->insert($data);
    return redirect('admin')->with('alert', 'Admin Berhasil Di Buat');
  }

  public function Usrdelete($id)
  {
    $data = DB::table('users')->delete($id);
    return redirect('admin')->with('alert', 'User Berhasil Di Hapus');
  }

  public function Usredit($id)
  {
    $data = DB::table('users')->find($id);

    return view('Usredit', compact('data'));
  }

  public function Usrupdate(Request $request)
  {
    // update data admin
    DB::table('users')->where('id', $request->id)->update([
      'username' => $request->get('username'),
      'password' => Hash::make($request['password']),
      'type' => $request->get('type'),
      'updated_at' => $request->get('updated_at'),
    ]);
    // alihkan halaman ke halaman admin
    return redirect('admin')->with('alert', 'Ticket berhasil Diubah.');
  }

  // Bagian Komentar

  // public function komentar(Request $request)
  // {
  //   $data = DB::table('komentar')->get();
  //   if (!Auth::check('login')) {
  //     return redirect('login')->with('alert', 'Kamu harus login dulu');
  //   } else {
  //     return view('komentar', compact('data'));
  //   }
  // }

  public function inskomentar(Request $request)
  {
    $data = [
      'name_komentar' => $request->get('name_komentar'),
      'message_komentar' => $request->get('message_komentar'),
      'id_ticket' => $request->get('id_ticket'),
      'created_by_komentar' => Auth::user()->username,
    ];
    $data = DB::table('komentar')->insert($data);
    return redirect('list')->with('alert', 'Komentar Berhasil Di Buat');
  }


  // Bagian Task

  public function task(Request $request)
  {
    $data = $request->session()->all();
    // dd($data);
    $data = Ticket::all();
    return view('task', compact('data'));
  }

  public function task_create()
  {
    return view('task_create');
  }

  public function task_insert(Request $request)
  {
    $data = [
      'created_by' => Auth::user()->username,
      'task_title' => $request->get('task_title'),
      'task_message' => $request->get('task_message'),
      'task_status' => $request->get('task_status'),
      'task_priority' => $request->get('task_priority'),
    ];


    $email_time = Carbon::now();

    $email_task = array(
      'created_by' => Auth::user()->username,
      'task_title' => $request->task_title,
      'c_date' => $email_time,
    );

    // dd($email_task);

    // $email_address = [
      // 'gaptekxricky@gmail.com',
      //'tulus.winarno@gmail.com',
      // 'greebe91n@gmail.com',
    // ];

    // Mail::to($email_address)->send(new sendingEmailTask($email_task));

    $data = DB::table('task_list')
      ->insert($data);
    return redirect('task')->with('alert', 'Task Berhasil Di Buat');
  }

  public function task_delete($id)
  {
    $data = DB::table('task_list')->delete($id);
    return redirect('task')->with('alert', 'Task Berhasil Di Hapus');
  }

  public function task_edit($id)
  {
    $data = DB::table('task_list')->find($id);

    return view('task_edit', compact('data'));
  }

  public function task_update(Request $request)
  {
    // update data admin
    DB::table('task_list')->where('id', $request->id)->update([
      'task_title' => $request->get('task_title'),
      'task_message' => $request->get('task_message'),
      'task_status' => $request->get('task_status'),
      'task_priority' => $request->get('task_priority'),
      'm_date' => $request->get('m_date'),
    ]);
    // alihkan halaman ke halaman admin
    return redirect('task')->with('alert', 'Task berhasil Diubah.');
  }

  public function task_read($id)
  {
    $data = Ticket::find($id);
    return view('task_read', compact('data'));
  }

  // export data

  public function export($id)
  {

    $data = DB::table('ticket_list')->find($id);

    $task['created_by'] = $data->created_by;
    $task['task_title'] = $data->tittle;
    $task['task_message'] = $data->message;
    $task['task_status'] = $data->status;
    $task['task_priority'] = $data->priority;

    // dd($task);

    $data = DB::table('task_list')
      ->insert($task);
    return redirect('list')->with('alert', 'Export Ke Task Berhasil');
  }

  public function getUserIdByUsername($requset, $username) 
  {
      $user =  User::where('username', '=', $username)->get()->first();
      $userId = $user->id;
      return $userId; 
  }

  public function setQueryDate($query, $dateFormat)
  {
    return $query->where('created_at', '>=', $dateFormat.' 00:00:00');
  }

  public function getRangeParams($queryParams) 
  {
    $ALLOWED_KEYS = ['to', 'from'];
    
    $range = array_filter(
      $queryParams,
      function ($key) use ($ALLOWED_KEYS) {
          return in_array($key, $ALLOWED_KEYS);
      },
      ARRAY_FILTER_USE_KEY
    );
    
    return $range;
  }

  

  public function filter(Request $request, Ticket $ticket) 
  {
    $requests = $request->all();
    $rangeQueryParams = $this->getRangeParams($requests);

    if ($request->exists('to'))  unset($requests['to'], $requests['from']);
  

    $query = $ticket::query();

    $removeNonValue = function ($value) {
      return (strlen($value) !== 0);
    };


    if (count($rangeQueryParams) !== 0) {
      $query->whereBetween('created_at', [$rangeQueryParams['from'].' 00:00:00', $rangeQueryParams['to'].' 23:59:59']);
    }

    $requestFiltered = $request->except('_token', 'origin', 'to', 'from');

    foreach ($requestFiltered as $key => $value) {

      if ($key === 'user') {
        $userId = $this->getUserIdByUsername($request, $value);
        $query->where("user_id", $userId);
      } else if ($key === 'created_at') {
        $query->whereBetween('created_at', [$value.' 00:00:00', $value.' 23:59:59']);
      } else if ($key === 'updated_at') {
        $query->whereBetween('updated_at', [$value.' 00:00:00', $value.' 23:59:59']);
      } else {
        $query->where($key, $value);
      }

    }

    $data = $query->get();

    return view('index', compact('data'));
    
    // return $pathOrigin === 'tasks'; 
    // if ($pathOrigin === 'tasks') {
    //   return redirect('tasks');
    // } else {
    //   return view('index', compact('data'));
    // }

  }

}
