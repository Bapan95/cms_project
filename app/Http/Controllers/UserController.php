<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Fetch paginated users (e.g., 10 users per page)
        $users = User::paginate(10);
    // print_r($users);
    // die;
        // Return the view with the paginated users data
        return view('users.index', compact('users'));
    }
    
}
