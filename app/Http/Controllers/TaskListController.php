<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use Illuminate\Http\Request;
use Validator;

class TaskListController extends Controller
{
    public function myTask(){
        $tasks = TaskList::where('user_id',auth()->id())->get(['id','title','description','created_at','status']);
        $response = [
            'success' => true,
            'data' =>  $tasks,
            'message' => 'Task List Here'
        ];
        return response()->json($response,200);
    }

    public function addTask(Request $req) {
        $input = $req->all();
        $validate = Validator::make($input,[
            'title' => 'required',
            'description' => 'required',
        ]);

        if($validate->fails()){
            $response = [
                'success' => false,
                'data' => 'Validation Error',
                'message' => $validate->errors()
            ];
            return response()->json($response,400);
        }

        $task = new TaskList();
        $task->title = $req->title;
        $task->user_id = auth()->id();
        $task->description = $req->description;
        $task->save();
        $tasks = TaskList::where('user_id',auth()->id())->get(['id','title','description','created_at','status']);
        $response = [
            'success' => true,
            'data' =>  $tasks,
            'message' => 'Task List Here'
        ];
        return response()->json($response,200);
    }
}
