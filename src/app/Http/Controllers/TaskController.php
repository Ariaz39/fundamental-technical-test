<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private const TASK_NOT_FOUND_RESPONSE = ['error' => 'Task not found'];

    /**
     * List tasks for the authenticated user, paginated (10 items per page)
     */
    public function index(Request $request)
    {
        $tasks = Task::where('user_id', auth()->id());
        return response()->json($tasks);
    }

    /**
     * Create a new task for the authenticated user
     */
    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();

        $task = Task::create([
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status'      => $validated['status'] ?? 'pending',
            'user_id'     => auth()->id(),
        ]);

        return response()->json($task, 201);
    }

    /**
     * Show details of a specific task belonging to the authenticated user
     */
    public function show($id)
    {
        $task = $this->getTask($id);

        if (!$task) {
            return response()->json(self::TASK_NOT_FOUND_RESPONSE, 404);
        }

        return response()->json($task);
    }

    /**
     * Update an existing task for the authenticated user
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $task = $this->getTask($id);

        if (!$task) {
            return response()->json(self::TASK_NOT_FOUND_RESPONSE, 404);
        }

        $validated = $request->validated();
        $task->update($validated);

        return response()->json($task);
    }

    /**
     * Delete a task for the authenticated user
     */
    public function destroy($id)
    {
        $task = $this->getTask($id);

        if (!$task) {
            return response()->json(self::TASK_NOT_FOUND_RESPONSE, 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }

    /**
     * Retrieve a task by ID that belongs to the authenticated user.
     *
     * @param mixed $id
     * @return Task|null
     */
    protected function getTask($id)
    {
        return Task::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
    }
}
