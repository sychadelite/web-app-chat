<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 

class AuthController extends Controller
{
    public function getAuthUser() {
        $user = User::where('id', Auth::id())
        ->first();

        return $user;
    }
}
