<?php

namespace App\Http\Controllers\Auth;

use App\Models\Auth\User\User;
use App\Notifications\Auth\ConfirmEmail;
use App\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;

class ConfirmController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('guest');
    }

    /**
     * Confirm user email
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm(User $user)
    {
        /*$user->confirmed = true;
        $user->save();

        auth()->login($user);
        return redirect()->intended(app(LoginController::class)->redirectPath());
        */
    }


    public function confirmar($code)
    {


        $user= User::where('confirmation_code',$code)->first();
        if($user){
            if($user->confirmed) {
                return 'El usuario ya está confirmado';
            }else{
                $user->confirmed = true;

                $user->save();

                auth()->login($user);
                return redirect()->intended(app(LoginController::class)->redirectPath());
            }

        }else{
            return 'No existe el usuario solicitado';
        }


    }
    public function sendEmail(User $user)
    {
        //create confirmation code
        $user->confirmation_code = Uuid::uuid4();
        $user->save();

        //send email
        $user->notify(new ConfirmEmail());

        return back()->with('status', __('auth.confirm'));
    }
}
