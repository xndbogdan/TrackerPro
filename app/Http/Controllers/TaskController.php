<?php


namespace App\Http\Controllers;

use App\Http\Models\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
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
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'status' => ['required', 'numeric', 'max:255'],
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return Task::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'status' => $data['status'],
            'user_id' => Auth::user()->id
        ]);
    }

    public function addTask(Request $request){
        $data = $request->all();
        $validator = $this->validator($data);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $task = $this->create($data);
        } catch(\Exception $ex){
            Log::error($ex->getMessage());
        }
        return redirect()->back();
    }

    public function deleteTask(Request $request){
        $task = Task::find($request->id);
        if($task->user_id == Auth::user()->id || Auth::user()->is_admin){
            $task->delete();
            $request->session()->flash('toast', "Task failed sucessfully");
        } else {
            $request->session()->flash('toast', "This is not your task, so you cannot delete it");
        }
        return redirect()->back();
    }

    public function editTask(Request $request){
        $task = Task::find($request->id);
        if($task->user_id == Auth::user()->id || Auth::user()->is_admin){
            $task->name = $request->name;
            $task->description = $request->description;
            $task->status = $request->status;
            $task->save();
            $request->session()->flash('toast', "Task edited sucessfully");
        } else {
            $request->session()->flash('toast', "This is not your task, so you cannot edit it");
        }
        return redirect()->back();
    }
}
