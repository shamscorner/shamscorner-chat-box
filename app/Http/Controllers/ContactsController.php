<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ContactsController extends Controller
{
    /**
    * Author: shamscorner
    * DateTime: 17/September/2019 - 19:03:54
    *
    * get contacts
    *
    */
    public function get()
    {
        $contacts = User::all();

        return response()->json($contacts);
    }
}
