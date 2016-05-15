<?php

namespace app\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Show the index
     *
     * @return mixed
     */
    public function index()
    {
        $users = get_company()->users(true);

        return view('pages.customers.index', compact('users'));
    }
}