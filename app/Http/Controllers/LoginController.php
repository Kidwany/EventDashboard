<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'email'         =>  'required',
            'password'      =>  'required',
        ], [] , [
            'receivers'     =>  'Type Of  receivers',
            'title'         =>  'Title',
            'desc'          =>  'Description Of Notification',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role_id' => 3, 'parent_id' => null])) {
            return redirect('/');
        }
        else
        {
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.failed')],
            ]);
        }
    }

    public function username()
    {
        return 'email';
    }
}
