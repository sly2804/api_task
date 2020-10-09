<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    
    public function __construct()
    {
        //
    }

    public function read_all(){
        $tasks=Task::select('id','name','mail','task','done')->simplePaginate(3);
        if ($tasks==NULL){
            return response()->json(['error'=>'empty data']);
        }
        return $tasks;
    }

    public function read($id){
        $this->validId($id);
        $task=Task::select('id','name','mail','task','done')->where('id', '=', $id)->first();
        if ($task==NULL){
            return response()->json(['error'=>'empty data']);
        }
        return $task;
    }
    public function create(Request $request){
        $this->valid($request);
        $task= new Task;
        $task->name = $request->input('name');
        $task->mail = $request->input('mail');
        $task->task = $request->input('task');
        $task->done = $request->input('done');
        try {
            $task->save();
        } catch (Exeption $e){
            return response()->json(['status' => 'Task not created','error'=>$e]);
        }
        return response()->json(['status' => 'Task created']);
    }
    public function modify(Request $request, $id){
        $this->validId($id);
        $this->valid($request);

        $task=Task::where('id','=',$id)->first();
        if ($task==NULL){
            return response()->json(['error'=>'empty modify data']);
        }
        $task->name = $request->input('name');
        $task->mail = $request->input('mail');
        $task->task = $request->input('task');
        $task->done = $request->input('done');
        try {
            $task->save();
        } catch (Exeption $e){
            return response()->json(['status' => 'Task not created','error'=>$e]);
        }
        return response()->json(['status' => 'Task modified', 'id'=>$id]);
    }
    public function delete($id){
        $this->validId($id);
        $task=Task::destroy($id);
        if ($task==NULL){
            return response()->json(['error'=>'empty data! no data for delete']);
        }
        return response()->json(['status'=>'deleted']);
    }
    private function valid(Request $request){
        $this->validate($request, [
            'name' => 'required|max:50',
            'mail' => 'required|email:rfc,dns',
            'task' => 'required|max:100',
            'done' => "required|boolean"
        ]);
    }
    private function validId($id){
        if (!is_numeric($id)){
            return response()->json(['error'=>'id must be numeric']);
        }
        return 1;
    }
    //
};
