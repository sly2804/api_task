<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $perPage = 3;
    private $allowField=[
                'id',
                'name',
                'mail',
                'task',
                'done'];

    public function __construct()
    {
        //
    }
    public function readAll(){
        $tasks=Task::select($this->allowField)->Paginate($this->perPage);
        return response()->json($tasks);
    }

    public function read($id){
        $validate = $this->validId($id);
        if ($validate){return $validate;}
        $task=Task::select($this->allowField)->where('id', '=', $id)->first();
        if ($task==NULL){
            return response()->json(['status'=>'not found'])->setStatusCode(404);
        }
        return response()->json($task)->setStatusCode(200);
    }
    public function create(Request $request){
        $this->valid($request);
        $newData=$this->makeNewData($request);
        $task= new Task($newData);
        try {
            $task->save();
        } catch (Exeption $e){
            return response()->json(['status' => 'Task not created','error'=>$e])->setStatusCode(500);
        }
        return response()->json(['status' => 'Task created', 'id'=>$task->id])->setStatusCode(201);
    }
    public function modify(Request $request, $id){
        $validate = $this->validId($id);
        if ($validate){return $validate;}
        $this->valid($request);
        $modifyData=$this->makeNewData($request);
        $task=Task::where('id','=',$id)->first();
        if ($task==NULL){
            return response()->json(['error'=>'empty modify data'])->setStatusCode(404);
        }

        try {
            $task->update($modifyData);
        } catch (Exeption $e){
            return response()->json(['status' => 'Task not modified','error'=>$e])->setStatusCode(500);
        }
        return response()->json(['status' => 'Task modified', 'id'=>$task->id])->setStatusCode(200);
    }
    public function delete($id){
        $validate = $this->validId($id);
        if ($validate){return $validate;}
        $task=Task::destroy($id);
        if ($task==NULL){
            return response()->json(['error'=>'empty data! no data for delete'])->setStatusCode(404);
        }
        return response()->json(['status'=>'deleted'])->setStatusCode(200);
    }
    private function valid(Request $request){
        $this->validate($request, [
            'name' => 'required|max:50',
            'mail' => 'required|email:rfc,dns',
            'task' => 'required|max:100',
            'done' => "required|boolean"
        ]);
        return 0;
    }
    private function validId($id){
        if (!is_numeric($id)){
            return response()->json(['error'=>'id must be numeric'])->setStatusCode(400);
        }
        return 0;
    }
    private function makeNewData (Request $request){
        $newData=[
            'name'=>$request->input('name'),
            'mail'=>$request->input('mail'),
            'task'=>$request->input('task'),
            'done'=>$request->input('done')
        ];
        return $newData;
    }
    //
};
