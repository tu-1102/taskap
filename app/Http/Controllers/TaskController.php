<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function taskCreate(Request $request, Task $task)
    {
        $userId = Auth::id();

        $task->task_title = $request->input('task_title');
        $task->task_description = $request->input('task_description');
        $task->start_date = $request->input('start_date');
        $task->end_date = $request->input('end_date');
        $task->task_color = $request->input('task_color');
        $task->is_completed = false;
        $task->user_id = $userId;
        $task->save();

        return redirect(route('dashboard'));
    }

    public function taskGet(Request $request, Task $task)
    {
        $start_date = date('Y-m-d H:i:s', $request->input('start_date') / 1000);
        $end_date = date('Y-m-d H:i:s', $request->input('end_date') / 1000);

        return $task->query()
            ->select(
                'id',
                'task_title as title',
                'task_description as description',
                'start_date as start',
                'end_date as end',
                'task_color as backgroundColor',
            )
            ->where('start_date', '>', $start_date)
            ->where('end_date', '<', $end_date)
            ->where('user_id', '=', Auth::id())
            ->where('is_completed', '=', false)
            ->get();
    }

    public function taskUpdate(Request $request, Task $task)
    {
        $task = Task::find($request->input('task_id'));
        $task->task_title = $request->input('task_title');
        $task->task_description = $request->input('task_description');
        $task->start_date = $request->input('start_date');
        $task->end_date = $request->input('end_date');
        $task->task_color = $request->input('task_color');
        $task->is_completed = filter_var($request->input('is_completed'), FILTER_VALIDATE_BOOLEAN);
        $task->save();

        return redirect(route("dashboard"));

    }

    public function taskDelete(Request $request, Task $task)
    {
        $task->find($request->input('id'))->delete();

        return redirect(route("dashboard"));
    }
}
