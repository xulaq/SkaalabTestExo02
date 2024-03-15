<?php

namespace App\Http\Controllers;

use App\Events\TaskUpdated;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json(TaskResource::collection($tasks));
    }

    public function store(Request $request)
    {
        $task = Auth::user()->tasks()->create($request->all());

        // Broadcast task creation event
        broadcast(new TaskUpdated())->toOthers();

        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());

        // Broadcast task update event
        broadcast(new TaskUpdated())->toOthers();

        return response()->json($task, 200);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        // Broadcast task deletion event
        broadcast(new TaskUpdated())->toOthers();

        return response()->json(null, 204);
    }

}
