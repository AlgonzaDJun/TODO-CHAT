<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Response;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $todos = Todo::with('user')->where('user_id', Auth::user()->id)->latest()->get();
            return view('todo.index', [
                'todos' => $todos
            ]);
        } else {
            return view('todo.index', [
                'todos' => []
            ]);
        }
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
    public function store(TodoRequest $request)
    {
        Todo::create([
            'user_id' => Auth::user()->id,
            'activity' => $request->activity,
        ]);
        return redirect('/')->withSuccess('Task Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(TodoRequest $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->update($request->all());
        return redirect('/')->withSuccess('Task Edited Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return redirect()->route('todo');
    }

    public function checked($id)
    {
        $todo = Todo::findOrFail($id);
        if ($todo->done === 0) {
            $todo->done = 1;
            $todo->update();
            return [
                'message' => 'Todo change Successfully!',
                'status' => 1
            ];
        } else {
            $todo->done = 0;
            $todo->update();
            return [
                'message' => 'Todo change Successfully!',
                'status' => 0
            ];
        }
    }
}
