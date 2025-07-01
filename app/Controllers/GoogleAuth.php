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
        $client->setRedirectUri(current_url());
        $client->addScope(\Google_Service_Calendar::CALENDAR);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        // If coming back from Google with code
        if ($code = $this->request->getGet('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($code);

            if (isset($token['error'])) {
                return "Error fetching token: " . $token['error_description'];
            }

            // Save token.json
            file_put_contents(WRITEPATH . 'token.json', json_encode($token));
            return "Access token saved to writable/token.json. You're ready to use the Meet API.";
        }

        // First time: redirect to Google OAuth consent
        return redirect()->to($client->createAuthUrl());
    }
}
