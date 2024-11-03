<?php

namespace App\Http\Controllers;

use App\Events\AddTodoName;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = session('todos', []);
        return view('todos.index', compact('todos'));
    }

    public function store(Request $request)
    {
        $request->validate(['message' => 'required']);

        $todos = session('todos', []);

        $message = $request->message;
    
        $todos[] = ['title' => $message];

        session(['todos' => $todos]);

        AddTodoName::dispatch($message);

        return $message;
    }
}
