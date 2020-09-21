<?php

namespace App\Http\Controllers;

use App\Country;
use App\Helpers\Helper;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Util\Str;

class UsersController extends Controller
{
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
                    'redirect'=>'/'], 200);;
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
                'error'=>'L\'email n\'a pas pu être envoyé'
            ], 500);
        }
        return $response;
    }

    public function confirmReset(Request $request, $slug)
    {
        if(User::checkColumn('forgot', $slug) == 0){
            $this->retour = Helper::getResponse(false, 'Ce link est invalide!');
            echo json_encode($this->retour);
            exit();
        }

        $dados = User::getColumn('id', 'forgot', $_POST['forgot'], true);
        $User = User::find($dados[0]->id);
        $User->password = Helper::hashPassword($_POST['password']);
        $User->forgot = null;

        try{
            $User->update();
            $this->retour = Helper::getResponse(true, 'Le mot de passe est modifié avec succès!');
        }catch (QueryException $e){
            $this->retour = Helper::getResponse(false, $e->getMessage());
        }finally{
            echo json_encode($this->retour);
            exit();
        }
    }

    private function createForgotHtml($forgot)
    {
        return '
        <p>
            Pour récupérer votre mot de passe, veuillez cliquer sur le lien suivant: <a href=\'http://127.0.0.1:8000/reset/'.$forgot.'\'>link</a>
        </p>
      ';
    }

    public function resetEmailView(Request $request, $slug)
    {
        $forgot = [
            'forgot'=> $slug
        ];

        return view('confirmPassword', compact('forgot'));
    }

    public function logout()
    {
        Auth()->logout();
        $countries = Country::all();
        return view('welcome',compact('countries'));
    }
}
