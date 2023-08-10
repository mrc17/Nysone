<?php

namespace App\Http\Controllers;

use App\Models\User;
use Twilio\Rest\Client;
use App\Http\Requests\ConnexionRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Http\Requests\verificationCodeRequest;

class UserController extends Controller
{
    public function vueinscription()
    {
        return view('user.inscription');
    }

    public function register(VerifyUserRequest $request)
    {
        $this->validate($request, [
            'Nom' => 'required',
            'Prenom' => 'required',
            'Telephone' => 'required',
            'email' => 'required|email',
        ]);

        $user = User::create([
            'nom' => $request->input('Nom'),
            'prenom' => $request->input('Prenom'),
            'telephone' => $request->input('Telephone'),
            'email' => $request->input('email'),
        ]);

        return redirect('user/confirmation');
    }

    public function vueconfirmation()
    {
        return view('user.confirmation');
    }

    public function vueconnexion()
    {
        return view('user.connexion');
    }

    public function store(ConnexionRequest $request)
    {
        $verify = User::where('telephone', $request->input('Telephone'))->first();

        if (!$verify) {
            return view('user.connexion', ['error' => 'Le numéro n\'existe pas']);
        }

        session()->put('Telephone', $verify->telephone);

        return redirect('qrcode/qrcode');
    }

    public function scanQrCode(){

        // Générer le code QR
        $data = rand(1000, 99999);

        // Stocker les informations dans la session
        session()->put('qr_code_data', $data);

        $telephone=session('Telephone');

       // dd($telephone);

        /* try {
            // Envoyer le message à l'utilisateur
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_number = getenv("TWILIO_NUMBER");

            $client = new Client($account_sid, $auth_token);

            // Utilisez $verify->telephone comme destinataire (to) pour le message
                $message = $client->messages->create(
                $telephone,
                [
                    'from' => $twilio_number,
                    'body' => $data,
                ]
            );
        } catch (\Exception $e) {
            // Gérer l'exception ici (par exemple, journalisation, affichage d'un message d'erreur, etc.)
            return view('user.connexion', ['error' => 'Erreur lors de l\'envoi du message Twilio']);
        }
 */
        return view('qrcode.scan');
    }

    public function code()
    {
        return view('qrcode.code');
    }

    public function verificationCode(VerificationCodeRequest $request)
    {
        $codeUser = $request->code;
        $dataCode = session('qr_code_data');

        if ($codeUser !== $dataCode) {
            return view('qrcode/code',['error' =>'Le code de vérification n\'est pas valide']);
        }

        return redirect('accueil');
    }


}
