<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Отримати всіх користувачів
        return view('users.index', compact('users')); // Передати користувачів до вигляду
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        // Перевірка на адміністратора для додаткової безпеки
        if (auth()->user()->IsAdmin) {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        }
        return back()->with('error', 'Unauthorized access.');
    }
}
