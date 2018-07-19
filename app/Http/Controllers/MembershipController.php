<?php

namespace App\Http\Controllers;

use App\Models\Auth\User\User;
use Illuminate\Http\Request;
use App\Cliente;
use App\Boleta;
use App\Periodo;
class MembershipController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin', ['except' => ['index', 'failed', 'clearValidationCache']]);
    }

    public function index(Request $request)
    {
        /** @var  $user User */
        $user = $request->user();


        $membership = collect([
            'valid' => true,
            'shopUrl' => null,
            'expires' => null,

        ]);

        if ($user->protectionValidation) {
            $validationResult = collect($user->protectionValidation->getValidationResult(config('protection.membership.product_module_number')));

            $membership->put('expires', $validationResult->get('expires'));

            $successUrl = route('protection.membership.clear_validation_cache', ['dest' => url()->current()]);
            $cancelUrl = url()->current();

            $protectionShopToken = protection_shop_token($user, $successUrl, $cancelUrl);

            $membership->put('shopUrl', $protectionShopToken->shop_url);
        }
        $cliente=Cliente::where("user_id",$user->id)->first();
        //dd($cliente);
        $periodo_lec=Periodo::where("activo_lectura",1)->first();
        $periodos=Periodo::where("id","<=",$periodo_lec->id)->get()->sortByDesc('id')->take(6)->reverse();

        return view('front.membership',["cliente"=>$cliente,"periodos"=>$periodos])->with($membership->toArray());
  // return view('front.membership')->with($membership->toArray()))->with($cliente->toArray());
    }

    public function pagar(Request $request)
    {
        /** @var  $user User */
        $user = $request->user();


        $membership = collect([
            'valid' => true,
            'shopUrl' => null,
            'expires' => null,

        ]);

        if ($user->protectionValidation) {
            $validationResult = collect($user->protectionValidation->getValidationResult(config('protection.membership.product_module_number')));

            $membership->put('expires', $validationResult->get('expires'));

            $successUrl = route('protection.membership.clear_validation_cache', ['dest' => url()->current()]);
            $cancelUrl = url()->current();

            $protectionShopToken = protection_shop_token($user, $successUrl, $cancelUrl);

            $membership->put('shopUrl', $protectionShopToken->shop_url);
        }
        $cliente=Cliente::where("user_id",$user->id)->first();
        $boletas=Boleta::where('estado_pago_id', '<>', 3)->where('cliente_id', $user->id)->get();
        //dd($cliente);
        $periodo_lec=Periodo::where("activo_lectura",1)->first();
        $periodos=Periodo::where("id","<=",$periodo_lec->id)->get()->sortByDesc('id')->take(6)->reverse();

        return view('front.pagar',["cliente"=>$cliente, "boletas"=>$boletas,"periodos"=>$periodos])->with($membership->toArray());
  // return view('front.membership')->with($membership->toArray()))->with($cliente->toArray());
    }

    public function pagarUpdate(Request $request)
    {
        $respuesta= [];
        $boleta = Boleta::where('cliente_id', $request->cliente_id)->where('estado_pago_id', '<>', 3)->get();

        foreach($boleta as $b){
          $b->estado_pago_id = 3;
          $b->save();
        }
        $respuesta["correcto"]=1;

        return  json_encode($respuesta);
    }






    public function failed(Request $request)
    {
        /** @var  $user User */
        $user = $request->user();

        $membership = collect([
            'valid' => false,
            'shopUrl' => null,
            'expires' => null,

        ]);

        if (!$user->protectionValidation) return redirect($request->get('dest', '/'));

        $validationResult = collect($user->protectionValidation->getValidationResult(config('protection.membership.product_module_number')));

        $membership->put('expires', $validationResult->get('expires'));

        $successUrl = route('protection.membership.clear_validation_cache', ['dest' => $request->get('dest', url('/'))]);
        $cancelUrl = url('/');

        $protectionShopToken = protection_shop_token($user, $successUrl, $cancelUrl);

        $membership->put('shopUrl', $protectionShopToken->shop_url);

        return view('membership')->with($membership->toArray());
    }

    public function clearValidationCache(Request $request)
    {
        /** @var  $user User */
        $user = $request->user();
        $user->load(['protectionValidation']);

        if ($user->protectionValidation) $user->protectionValidation->delete();

        return redirect($request->get('dest', '/'));
    }
}
