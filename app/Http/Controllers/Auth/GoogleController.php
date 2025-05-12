<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => bcrypt(Str::random(16)),
                    'role_id' => 1, // default: user biasa
                    'CompanyCode' => null,
                    'Status' => 1,
                    'IsDeleted' => 0,
                    'CreatedBy' => 'google',
                    'CreatedDate' => Carbon::now(),
                    'LastUpdateBy' => 'google',
                    'LastUpdateDate' => Carbon::now(),
                ]
            );

            Auth::login($user);

            return redirect('/dashboard'); // ubah sesuai tujuan login
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal login Google: ' . $e->getMessage());
        }
    }
}
