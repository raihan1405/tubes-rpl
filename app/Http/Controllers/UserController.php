<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
{
    $this->middleware('developer')->only('index');
}

    public function index()
    {
        $users = User::all();
        return view('admin.userIndex', ['users' => $users]);
    }

    public function accept(User $user)
    {
        // Update the user status to 'approved'
        $user->update(['status' => 'approved']);

        // Redirect or return a response as needed
        return redirect()->back();
    }

    public function reject(User $user)
    {
        // Update the user status to 'rejected'
        $user->update(['status' => 'rejected']);

        // Redirect or return a response as needed
        return redirect()->back();
    }
};