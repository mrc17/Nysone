<?php

namespace App\Http\Controllers;

use App\Models\User;
use Twilio\Rest\Client;
use Endroid\QrCode\QrCode;
use Illuminate\Support\Str;
use App\Http\Requests\ConnexionRequest;
use App\Http\Requests\VerifyUserRequest;
use Endroid\QrCode\Writer\PngWriter;



class UserController extends Controller
{
    // Définition de la fonction pour afficher la page Inscription
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

        // Générer le code QR
        $data = rand(1000, 99999);

        // Stocker les informations dans la session
        session()->put('qr_code_data', $data);
        session()->put('Telephone', $verify->telephone);

        return redirect('qrcode/qrcode');
    }


    public function scanQrCode()
    {
        return view('qrcode.scan');
    }


    public function sendMessage()
    {
        $data = session('qr_code_data');
        // Envoyer le message à l'utilisateur
        $twilioSid = 'YOUR_TWILIO_SID';
        $twilioToken = 'YOUR_TWILIO_AUTH_TOKEN';
        $twilioFromNumber = User::where('telephone', session('Telephone'))->first()->telephone;
        $userPhoneNumber = 'USER_PHONE_NUMBER';

        $client = new Client($twilioSid, $twilioToken);
        $message = $client->messages->create(
            $userPhoneNumber,
            [
                'from' => $twilioFromNumber,
                'body' => $data,
            ]
        );

        // Effacer les informations de la session
        session()->forget('qr_code_data');
        session()->forget('qr_code_image');

        return redirect('accueil');
    }
}
