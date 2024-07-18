<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __invoke()
    {
        $users = User::query()
            ->paginate();

        return view('users.index', compact('users'));
    }
}
