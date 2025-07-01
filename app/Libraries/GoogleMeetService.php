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

    public function createMeetLink(string $summary, string $date, string $time, int $durationMinutes = 15, array $attendees = [])
    {
        $start = new DateTime("{$date} {$time}", new DateTimeZone('Asia/Kolkata'));
        $end   = clone $start;
        $end->modify("+{$durationMinutes} minutes");

        $startTimeRFC = $start->format(DateTime::RFC3339);
        $endTimeRFC   = $end->format(DateTime::RFC3339);

        $event = new \Google_Service_Calendar_Event([
            'summary' => $summary,
            'start' => [
                'dateTime' => $startTimeRFC,
                'timeZone' => 'Asia/Kolkata',
            ],
            'end' => [
                'dateTime' => $endTimeRFC,
                'timeZone' => 'Asia/Kolkata',
            ],
            'attendees' => array_map(fn($email) => ['email' => $email], $attendees),
            'conferenceData' => [
                'createRequest' => [
                    'requestId' => uniqid(),
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                ],
            ],
        ]);

        $createdEvent = $this->calendarService
            ->events
            ->insert('primary', $event, ['conferenceDataVersion' => 1]);

        return [
            'meet_link'     => $createdEvent->getHangoutLink(),
            'calendar_link' => $createdEvent->htmlLink,
            'start'         => $start->format('d-m-Y h:i A'),
            'end'           => $end->format('d-m-Y h:i A'),
        ];
    }

}
