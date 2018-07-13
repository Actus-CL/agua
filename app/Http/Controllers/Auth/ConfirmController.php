<?php

namespace App\Http\Controllers\Auth;

use App\Models\Auth\User\User;
use App\Notifications\Auth\ConfirmEmail;
use App\Mail\ConfirmarUsuario;
use App\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;
use App\Cliente;
use Mail;

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

    }


    public function confirmar($code)
    {


        $user= User::where('confirmation_code',$code)->first();
        if($user){
            if($user->confirmed) {


                return redirect(route('error'))->with('status', __('auth.confirmed.dos'));

            }else{
                $user->confirmed = true;

                $user->save();

                auth()->login($user);
                return redirect()->intended(app(LoginController::class)->redirectPath())->with('status', __('auth.confirmed'));
            }

        }else{
            return redirect(route('error'))->with('status', __('auth.confirmed.no.existe'));

        }


    }
    public function sendEmail(User $user)
    {

        //create confirmation code
        $user->confirmation_code = Uuid::uuid4();
        $user->save();

        $cliente_correo=Cliente::where('user_id',$user->id)->first();
        //send email
        $user->notificar(new ConfirmarUsuario($cliente_correo));
        //dd($cliente_correo);
       // Mail::to("rinostrozareb@gmail.com")->queue(new ConfirmarUsuario($cliente_correo));


        return back()->with('status', __('auth.confirm'));
    }
}
