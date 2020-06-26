<?php

namespace Cyaxaress\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Cyaxaress\User\Http\Requests\SendResetPasswordVerifyCodeRequest;
use Cyaxaress\User\Http\Requests\VerifyCodeRequest;
use Cyaxaress\User\Models\User;
use Cyaxaress\User\Services\VerifyCodeService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;


    public function showVerifyCodeRequestForm()
    {
        return view('User::Front.passwords.email');
    }

    public function sendVerifyCodeEmail(SendResetPasswordVerifyCodeRequest $request)
    {
        // todo use UserRepository
        $user = User::query()->where('email', $request->email)->first();

        // check if code exists
        if ($user) {
            $user->sendResetPasswordRequestNotification();
        }

        return view('User::Front.passwords.enter-verify-code-form');
    }

    public function checkVerifyCode(VerifyCodeRequest $request)
    {
        // todo email validation
        // todo use UserRepository
        $user = User::query()->where('email', $request->email)->first();

        if (! VerifyCodeService::check($user->id, $request->verify_code)) {
            return back()->withErrors(['verify_code' => 'کد وارد شده معتبر نمیباشد!']);
        }

        auth()->loginUsingId($user->id);

        return redirect()->route('password.showResetForm');

    }
}
