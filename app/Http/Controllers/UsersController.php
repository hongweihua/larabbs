<?php
/**
 * Created by PhpStorm.
 * User: whhong
 * Date: 2018/1/11
 * Time: 17:46
 */
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}