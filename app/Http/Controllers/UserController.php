<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('developer')->only('index');
    // }

    public function index()
    {
        $users = User::all();
        return view('admin.userIndex', compact('users'));
    }

    // public function accept(User $user)
    // {
    //     
    //     $user->update(['status' => 'approved']);

    //     
    //     return redirect()->back();
    // }

    // public function reject(User $user)
    // {
    //    
    //     $user->update(['status' => 'rejected']);

    //    
    //     return redirect()->back();
    // }
};