<?php

namespace App\Http\Controllers;

use App\Classes\Messaging\Mailers\UserMailer;
use App\Classes\Messaging\Newsletters\NewsletterList;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;

class UsersController extends Controller
{
    private $newsletterList;

    private $mailer;

    /**
     * @param NewsletterList $newsletterList
     * @param UserMailer $mailer
     */
    public function __construct(NewsletterList $newsletterList, UserMailer $mailer)
    {
        $this->middleware('auth', ['only' => ['edit']]);

        $this->newsletterList = $newsletterList;

        $this->mailer = $mailer;
    }

    public function edit($id)
    {
        $user = Auth::user();

        return View::make('users.edit')->withUser($user);
    }

    public function update($id)
    {

        Auth::user()->updateCredentials(Input::all());

        // instead do this in event listener

        $email = Auth::user()->email;

        $method = Input::get('notify') ? 'subscribeTo' : 'unsubscribeFrom';

        $this->newsletterList->{$method}('initialSubscribers', $email);

        return 'Done.';
    }
}
