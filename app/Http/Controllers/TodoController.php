<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::all();

        return [
            "todos" => $todos,
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required',
            'status' => 'required',
            'priority' => 'required',
        ]);

        $result = Todo::create($validated_data);

        if ($result) {
            return [
                "Result" => "Data successfully saved.",
            ];
        } else {
            return [
                "Result" => "Data failed to save.",
            ];
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
        $todo = Todo::find($id);

        if ($todo) {
            return [
                "id" => $todo->id,
                "tasks" => $todo->name,
                "priority" => $todo->priority,
                "status" => $todo->status,
                "created_at" => $todo->created_at,
                "updated_at" => $todo->updated_at,
            ];
        } else {
            return ["result" => "Data not found"];
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $todo = Todo::findOrFail($id);

        $todo->name = $request->name;
        $todo->priority = $request->priority;
        $todo->status = $request->status;

        $result = $todo->save();

        if ($result) {
            return ["Result" => "Data has been saved."];
        } else {
            return ["Result" => "Data failed to save."];
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
        $ids = explode(',', $id);

        foreach ($ids as $id) {
            $result = Todo::where('id', $id)->delete();
        }

        if ($result) {
            return ["Result" => "Record " . implode(',', $ids) . " has been deleted"];
        } else {
            return ["Result" => "Record failed to delete."];
        }
    }
}
