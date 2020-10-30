<?php

namespace App\Auth;

use App\Models\User;

class Auth
{

    public function user()
    {
        if (isset($_COOKIE["user"]))
            return User::find($_COOKIE["user"]);
    }


    public function check()
    {
        if (isset($_COOKIE["user"]))
            return $_COOKIE["user"];
    }


    public function attempt($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            setcookie("user", $user->id);
            return true;
        }

        return false;
    }

    public function logout()
    {
        setcookie("user", "", time() - 3600);
    }
}
