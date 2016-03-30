<?php

namespace App\Http\Controllers;

use App\Classes\User;
use Illuminate\Http\Request;
use App\Http\Requests;use Illuminate\Routing\Controller;

class ActivitiesController extends Controller
{
    public function show(User $username)
    {
        $activity = $username->activity;

        return view('activity.show', compact('activity'));
    }
}
