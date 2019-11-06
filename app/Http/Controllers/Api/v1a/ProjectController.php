<?php

namespace App\Http\Controllers\Api\v1a;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            $projects = Project::all();

            if (!$projects->isEmpty()) {
                return response()->json([
                    'projects'  => $projects,
                ], 200);
            } else {
                return response()->json([
                    'error' => "No project found",
                ], 404);
            }
        } catch (Exception $ex) {
            return response()->json([
                'error' => "Can't list projects",
            ], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $projects = Project::create($request->all());

            return response()->json([
                'error' => false,
                'project'  => $projects,
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'error' => "Can't create this project",
            ], 500);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $project = Project::find($id);
            if (empty($project)) {
                return response()->json([
                    'error' => "Project " . $id . " not found",
                ], 404);
            }
            return response()->json([
                'project'  => $project,
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

    public function update(Request $request, $id)
    {
        try {
            $project = Project::find($id);
            if (empty($project)) {
                return response()->json([
                    'error' => "Project " . $id . " not found",
                ], 404);
            }

            $project->name = $request->input('name');
            $project->archived = $request->input('archived');

            if ($project->save()) {
                return response()->json([
                    'project'  => $project,
                ], 200);
            } else {
                return response()->json([
                    'error' => "Database error : can't update project " . $id,
                ], 500);
            }
        } catch (Exception $ex) {
            return response()->json([
                'error' => "Can't update this project",
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $project = Project::find($id);
            if (empty($project)) {
                return response()->json([
                    'error' => "Project " . $id . " not found",
                ], 404);
            }

            //Task::destroyByProject($id);

            if ($project->delete()) {
                return response()->json([
                    'message'  => "The project $project->id has successfully been deleted.",
                ], 200);
            } else {
                return response()->json([
                    'error' => "Database error : can't delete project " . $id,
                ], 500);
            }
        } catch (Exception $ex) {
            return response()->json([
                'error' => "Can't delete this project",
            ], 500);
        }
    }
    public function setArchived(Request $request, $id)
    {
        try {
            $project = Project::find($id);
            if (empty($project)) {
                return response()->json([
                    'error' => "Project " . $id . " not found",
                ], 404);
            }

            $project->archived = $request->input('archived');

            if ($project->save()) {
                return response()->json([
                    'project'  => $project,
                ], 200);
            } else {
                return response()->json([
                    'error' => "Database error : can't archive project " . $id,
                ], 500);
            }
        } catch (Exception $ex) {
            return response()->json([
                'error' => "Can't archive this project",
            ], 500);
        }
    }
    // public function addTask(Request $request, $id)
    // {
    //     try {
    //         $project = Project::find($id);
    //         if (empty($project)) {
    //             return response()->json([
    //                 'error' => "Project " . $id . " not found",
    //             ], 404);
    //         }

    //         if ($task = $project->tasks()->create([
    //             'name' => $request->input('name'),
    //             'started_at' => $request->input('started_at'),
    //             'stopped_at' => $request->input('stopped_at'),
    //         ])) {
    //             return response()->json([
    //                 'task'  => $task,
    //             ], 200);
    //         } else {
    //             return response()->json([
    //                 'error' => "Database error : can't add task to project " . $id,
    //             ], 500);
    //         }
    //     } catch (Exception $ex) {
    //         return response()->json([
    //             'error' => "Can't add task to this project",
    //         ], 500);
    //     }
    // }
    // public function viewTask($id)
    // {
    //     $tasks = Task::all();
    //     try {
    //         $project = Project::find($id);
    //         if (empty($project)) {
    //             return response()->json([
    //                 'error' => "Project " . $id . " not found",
    //             ], 404);
    //         }
    //         return response()->json([
    //             'tasks'  => $tasks,
    //         ], 200);
    //     } catch (Exception $ex) {
    //         return response()->json([
    //             'error' => "Can't create this project",
    //         ], 500);
    //     }

    // }
}
