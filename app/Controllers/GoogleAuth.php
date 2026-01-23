<?php

namespace App\Controllers;

use Google_Client;
use CodeIgniter\Controller;

class GoogleAuth extends Controller
{
    public function index()
    {
        $client = new Google_Client();

        $client->setAuthConfig(WRITEPATH . 'credentials.json');
        $client->setRedirectUri(base_url('google-auth'));

        $client->addScope('https://www.googleapis.com/auth/calendar');
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->setIncludeGrantedScopes(true);

        // Step 2: Handle callback
        if ($code = $this->request->getGet('code')) {

            $token = $client->fetchAccessTokenWithAuthCode($code);

            if (isset($token['error'])) {
                return "Error fetching token: " . $token['error_description'];
            }

            file_put_contents(
                WRITEPATH . 'token.json',
                json_encode($token)
            );

            return "✅ Google Calendar authorized successfully.<br>
                    token.json created in writable/.<br>
                    You can now close this page.";
        }

        // Step 1: Redirect to Google consent screen
        return redirect()->to($client->createAuthUrl());
    }
}
