<?php

namespace App\Http\Controllers\Api\v1a;

use App\Task;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($projectId)
    {
        try {
            $tasks = Task::all();

            if (!$tasks->isEmpty()) {
                return response()->json([
                    'tasks'  => $tasks,
                ], 200);
            } else {
                return response()->json([
                    'error' => "No Task found",
                ], 404);
            }
        } catch (Exception $ex) {
            return response()->json([
                'error' => "Can't list Tasks",
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $projectId)
    {
        try {
            $project = Project::find($projectId);
            if (empty($project)) {
                return response()->json([
                    'error' => "Project " . $projectId . " not found",
                ], 404);
            }

            if ($task = $project->tasks()->create([
                'name' => $request->input('name'),
                'started_at' => $request->input('started_at'),
                'stopped_at' => $request->input('stopped_at'),
            ])) {
                return response()->json([
                    'task'  => $task,
                ], 200);
            } else {
                return response()->json([
                    'error' => "Database error : can't add task to project " . $projectId,
                ], 500);
            }
        } catch (Exception $ex) {
            return response()->json([
                'error' => "Can't add task to this project",
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($projectId, $taskId)
    {
        try {
            $task = Task::find($taskId);
            if (empty($task)) {
                return response()->json([
                    'error' => "Task" . $taskId . " not found",
                ], 404);
            }
            return response()->json([
                'task'  => $task,
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'error' => "Can't create this project",
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $projectId, $taskId)
    {
        //
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyByProject($projectId)
    {
        try {
            $project = Project::find($projectId);
            if (empty($project)) {
                return response()->json([
                    'error' => "Project " . $projectId . " not found",
                ], 404);
            }

            Task::destroyByProject($projectId);

            return response()->json([
                'message'  => "All the tasks has successfully been deleted.",
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'error' => "Can't supp tasks of project $projectId",
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($projectId, $taskId)
    {
        try {
            $task = Task::find($taskId);
            if (empty($task)) {
                return response()->json([
                    'error' => "Task " . $taskId . " not found",
                ], 404);
            }

            if ($task->delete()) {
                return response()->json([
                    'message'  => "The task has successfully been deleted.",
                ], 200);
            } else {
                return response()->json([
                    'error' => "Database error : can't supp task to task " . $taskId,
                ], 500);
            }
        } catch (Exception $ex) {
            return response()->json([
                'error' => "Can't supp task $taskId to project $projectId",
            ], 500);
        }
    }
}
