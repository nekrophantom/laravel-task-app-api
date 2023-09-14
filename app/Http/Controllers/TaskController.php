<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('user', 'categories')->get();
        
        $response = $tasks->map(function ($task){
            return [
                'id'            => $task->id,
                'categoryName'  => $task->categories->name,
                'title'         => $task->title,
                'description'   => $task->description,
                'due_date'      => $task->due_date,
                'userName'      => $task->user->name,
                'priority'      => $task->priority,
                'status'        => $task->status,
                'created_at'    => $task->created_at,
                'updated_at'    => $task->updated_at       
            ];  
        });

        return ResponseHelper::onSuccess('All Task', $response, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return ResponseHelper::onSuccess('Create new Task', $categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'category_id'   => 'required|exists:categories,id',
                'title'         => 'required',
                'description'   => 'required',
                'due_date'      => 'required|date',
                'user_id'       => 'nullable|exists:users,id',
                'priority'      => 'required',
                'status'        => 'required'
            ]);

            $task               = new Task();
            $task->category_id  = $request->category_id;
            $task->title        = $request->title;
            $task->description  = $request->description;
            $task->due_date     = $request->due_date;
            $task->user_id      = Auth::user()->id;
            $task->priority     = $request->priority;
            $task->status       = $request->status;
            $task->save();

            DB::commit();

            return ResponseHelper::onSuccess('Success Create new Task', $task, 200);

        } catch (\Throwable $th) {
            DB::rollback();
            return ResponseHelper::onError('Error Create a new Task', 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return ResponseHelper::onSuccess('Task Detail' , $task, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return ResponseHelper::onSuccess("Edit Task ", $task, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'category_id'   => 'required|exists:categories,id',
                'title'         => 'required',
                'description'   => 'required',
                'due_date'      => 'required|date',
                'user_id'       => 'nullable|exists:users,id',
                'priority'      => 'required',
                'status'        => 'required'
            ]);
            
            $task->category_id  = $request->category_id;
            $task->title        = $request->title;
            $task->description  = $request->description;
            $task->due_date     = $request->due_date;
            $task->user_id      = Auth::user()->id;
            $task->priority     = $request->priority;
            $task->status       = $request->status;
            $task->save();

            DB::commit();
            return ResponseHelper::onSuccess('Success update task ' + $task->title, $task, 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::onError('Error update task ' + $task->title , 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        DB::beginTransaction();
        try {
            
            $task->delete();
            DB::commit();
            return ResponseHelper::onSuccess('Success delete task ' + $task->title, null, 200);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::onError('Error delete task', 401);
        }
    }
}
