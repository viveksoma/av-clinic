<?php

namespace App\Libraries;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Google_Service_Calendar_ConferenceData;
use DateTime;
use DateTimeZone;


class GoogleMeetService
{
    protected $client;
    protected $calendarService;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(WRITEPATH . 'credentials.json');
        $this->client->addScope(Google_Service_Calendar::CALENDAR);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');

        // Load token from file (or DB)
        $tokenPath = WRITEPATH . 'token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $this->client->setAccessToken($accessToken);

            // Refresh if expired
            if ($this->client->isAccessTokenExpired()) {
                $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                file_put_contents($tokenPath, json_encode($this->client->getAccessToken()));
            }
        }

        $this->calendarService = new Google_Service_Calendar($this->client);
    }

    public function createMeetLink(
        string $summary,
        string $date,
        string $time,
        int $durationMinutes = 15,
        array $attendees = []
    ): array {

        $start = new DateTime("{$date} {$time}", new DateTimeZone('Asia/Kolkata'));
        $end   = clone $start;
        $end->modify("+{$durationMinutes} minutes");

        $event = new Google_Service_Calendar_Event([
            'summary' => $summary,

            'start' => [
                'dateTime' => $start->format(DateTime::RFC3339),
                'timeZone' => 'Asia/Kolkata',
            ],

            'end' => [
                'dateTime' => $end->format(DateTime::RFC3339),
                'timeZone' => 'Asia/Kolkata',
            ],

            // 🔥 Attendees (patient + clinic email)
            'attendees' => array_map(
                fn ($email) => ['email' => $email],
                $attendees
            ),

            // 🔥 Google Meet creation
            'conferenceData' => [
                'createRequest' => [
                    'requestId' => uniqid('', true),
                    'conferenceSolutionKey' => [
                        'type' => 'hangoutsMeet',
                    ],
                ],
            ],
        ]);

        // 🔥 VERY IMPORTANT: sendUpdates = all
        $createdEvent = $this->calendarService->events->insert(
            'primary',
            $event,
            [
                'conferenceDataVersion' => 1,
                'sendUpdates' => 'all', // <-- THIS sends calendar invites
            ]
        );

        return [
            'meet_link'   => $createdEvent->getHangoutLink(),
            'event_id'    => $createdEvent->getId(),
            'calendarUrl' => $createdEvent->getHtmlLink(),
            'start'       => $start->format('d M Y h:i A'),
            'end'         => $end->format('d M Y h:i A'),
        ];
    }


}
