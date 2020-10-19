<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Traits\SystemTrait;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendMailForLowBalance extends Command
{
    use SystemTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:lowBalanceEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to user on low balance!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      $users = DB::table('users')
           ->where('level','=',3)
           ->where('balance','<',35)
           ->get();

      foreach ($users as $user){
          $html = $this->lowBalanceHTML([
              'name'=>$user->name,
              'balance'=>$user->balance
          ]);

          if(Helper::sendEmail([
              'subject'=>'Avis de recharge',
              'body'=>$html,
              'name'=>$user->name,
              'email'=>$user->email
          ])){
              $this->createLog('AVIS DE RECHARGE',$html,$user->email);
          }
      }
    }

    private function lowBalanceHTML($user){
        return '
        <p>
        Chèr(e) '.$user['name'].', <br><br>
            Nous vous alertons que votre solde de <b>'.number_format($user['balance'],2).' BRL(reais)</b> est faible!<br><br>
            <span>Veuillez entrer en contact avec l\'administrateur du système pour recharger votre compte e continuer à vendre avec toute tranquilité!</span>
        </p>
        <hr>
        Merci d\'avoir utilisé les services de <em><b>toprecharging.com</b></em> !<br><br>
        Pour toutes informations supplémentaires, veuillez nous contacter sur: <br><br>
        <span><b>Téléphone: </b>+55 (49) 99966-9170 / (11) 97774-4854</span><br>
        <span><b>Email: </b>contact@toprecharging.com</span><br>
        <span><b>Website: </b><a href="https://toprecharging.com">www.toprecharging.com</a></b></span>
      ';
    }
}
