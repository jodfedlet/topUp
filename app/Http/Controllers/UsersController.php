<?php

namespace App\Http\Controllers;

use App\Country;
use App\Events\Accueil;
use App\Helpers\Helper;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    private $addBalance = false;
    public function index()
    {
        if(Auth::guest()){
            return view('login');
        }
        $countries = Country::all();
        return view('welcome',compact('countries'));
    }

    public function logon(Request $request)
    {
        $data = $request->all();

        if(Auth::attempt([
            'email'=>$data['email'],
            'password'=>$data['password']
        ])){
            $redirect = (Auth::user()->level == 2) ? '/':'/adm';
            $response = response()->json([
                'userId'=>Auth::id(),
                'redirect'=>$redirect
            ], 200);
        }
        else{
            $response = response()->json(['error'=>'Incorrect user and/or password'], 500);
        }
        return $response;
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $user                 = new User();
        if(User::checkColumn('email', $data['email']) > 0){
            $response = response()->json(['error'=>'Il existe déjà un utilisateur avec ces informations, veuillez vous connecter!'], 500);
        }else{
            try{
                $user->name           = $data['name'];
                $user->email          = $data['email'];
                $user->password       = bcrypt($data['password']);
                $user->save();
                $response = response()->json([
                    'userId'=>Auth::id(),
                    'redirect'=>'/'], 200);
            }catch (QueryException $e){
                $response = response()->json(['error'=>$e->getMessage()], 500);
            }
        }
        return $response;
    }

    public function resetEmail(Request $request)
    {
        $data = $request->all();

        if(User::checkColumn('email', $data['email']) == 0){
            return response()->json([
                'error'=>'Cet email est inéxistant!'
            ], 500);
        }

        $dados = User::getColumn('email', '*', $data['email']);

        $User = User::find($dados[0]->id);

        $User->forgot = (md5(uniqid(rand(),true)));
        $User->update();

        $data = [
            'subject'=>'Récupération de mot de passe',
            'body'=>$this->createForgotHtml($User->forgot),
            'name'=>$User->name,
            'email'=>$User->email
        ];
        if(Helper::sendEmail($data)){
            $response = response()->json([
                'message'=>'Un lien s\'est envoyé à votre email afin de récupérer le mot de passe'
            ], 200);
        }
        else{
            $response = response()->json([
                'error'=>'L\'email n\'a pas pu être envoyé! Veuillez réessayer plus tard!'
            ], 500);
        }
        return $response;
    }

    public function confirmReset(Request $request)
    {
        $data = $request->all();

        if (empty($data['forgot']) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $data['forgot'])
            || User::checkColumn('forgot', $data['forgot']) == 0
        ){
            $response = response()->json([
                'error'=>'Le lien est invalide! Veuillez réessayer!'
            ], 500);
        }
        else {
            $dados = User::getColumn('forgot', 'id', $data['forgot']);

            $User = User::find($dados[0]->id);
            $User->password = bcrypt($data['password']);
            $User->forgot = null;

            try {
                $User->update();
                $response = response()->json([
                    'message'=>'Le mot de passe est modifié avec succès!'
                ], 200);
            } catch (QueryException $e) {
                $response = response()->json([
                    'error'=>$e->getMessage()
                ], 500);
            }
        }
        return $response;
    }

    private function createForgotHtml($forgot)
    {
        return '
        <p>
            Pour récupérer votre mot de passe, veuillez cliquer sur le lien ci-dessous: <br><br>
             <a href=\'https://toprecharging.com/reset/'.$forgot.'\'>Lien de récupération</a>
        </p>
      ';
    }

    private function rechargeHTML($data)
    {
        return '
        <p>
        Chèr(e) '.$data['resellerName'].', <br><br>
            Le montant de '.number_format($data['amount'],2).' BRL(reais) est ajouté sur votre solde avec succès!<br><br>
            <span><b><em>Nouveau solde: </em></b><span>'.number_format($data['balance'],2).'</span><b><em> BRL.</em></b></span>
        </p>
        <hr>
        Merci d\'avoir utilisé les services de <em><b>toprecharging.com</b></em> !<br><br>
        Pour toutes informations supplémentaires, veuillez nous contacter sur: <br><br>
        <span><b>Téléphone: </b>+55 (49) 99966-9170 / (11) 97774-4854</span><br>
        <span><b>Email: </b>contact@toprecharging.com</span><br>
        <span><b>Website: </b><a href="https://toprecharging.com">www.toprecharging.com</a></b></span>
      ';
    }

    public function resetEmailView(Request $request, $slug)
    {
        $forgot = [
            'forgot'=> $slug
        ];

        return view('confirmPassword', compact('forgot'));
    }

    public function showReseller()
    {
        $resellers = json_decode(DB::table('users')
            ->where('id','!=', Auth::id())
            ->where('level', '!=','1')
            ->get());
        event(new Accueil);
        return view('adm.system.reseller.read',compact('resellers'));
    }

    public function getResellerData(Request $request)
    {
        return response()->json([
            'data'=> User::find($request->all()['id'])
        ], 200);
    }

    public function resellerBalance(Request $request)
    {
        $data = $request->all();
        $reseller = User::find($data['id']);
        if (isset($data['operation']) && $data['operation'] == 'add'){
            $reseller->balance+=$data['amount'];
            $message = 'Balance added successfully';
            $this->addBalance = true;
        }
        else{
            if ($data['amount'] <= $reseller->balance){
                $reseller->balance-=$data['amount'];
                $message = 'Balance removed successfully!';
            }
            else{
                return response()->json([
                    'error' => 'Remove balance can not be superior than the current balance!'
                ], 500);
            }
        }

        try {
            if($reseller->update()) {
                 if($this->addBalance && Helper::sendEmail([
                    'subject'=>'Recharge du solde',
                    'body'=>$this->rechargeHTML([
                        'resellerName'=>$reseller->name,
                        'amount'=>$data['amount'],
                        'balance'=>$reseller->balance,
                    ]),
                    'name'=>$reseller->name,
                    'email'=>$reseller->email
                 ])){
                     $message = $message.' and an email has been sent to notice '.$reseller->name.'('.$reseller->email.')';
                 }
                $response = response()->json([
                    'redirect' => '/adm/reseller',
                    'message' => $message
                ], 200);
            }else{
                $response = response()->json([
                    'error' => $message
                ], 500);
            }
        }
        catch (\Exception $exception){
            $response = response()->json([
                'error' => $exception->getMessage()
            ], 500);
        }
        return $response;
    }

    public function logout()
    {
        Auth()->logout();
        $countries = Country::all();
        return redirect()->route('welcome',compact('countries'));
    }
}
