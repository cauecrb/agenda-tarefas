<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function index()
    {
        return TaskResource::collection(Tasks::all());
    }

    public function store(Request $request)
    {
        $task = Tasks::create($request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'due_date' => 'required|date',
            'completed' => 'boolean'
        ]));

        return new TaskResource($task);
    }

    public function show(Tasks $task)
    {
        return new TaskResource($task);
    }

    public function update(Request $request, Tasks $task)
    {
        $task->update($request->validate([
            'title' => 'sometimes|required',
            'description' => 'nullable',
            'due_date' => 'sometimes|required|date',
            'completed' => 'sometimes|boolean'
        ]));

        return new TaskResource($task);
    }

    public function destroy(Tasks $task)
    {
        $task->delete();

        return response()->noContent();
    }
}