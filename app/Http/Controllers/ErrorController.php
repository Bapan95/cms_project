<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    /**
     * Show the 403 Forbidden error page.
     *
     * @return \Illuminate\View\View
     */
    public function forbidden()
    {
        return view('errors.403');
    }
}
