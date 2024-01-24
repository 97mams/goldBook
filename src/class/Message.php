<?php
namespace App\class;

use DateTime;

class Message
{
    const LIMIT_USERNAME = 3;
    const LIMIT_MESSAGE = 10;
    private ?string $username;
    private ?string $message;
    private ?DateTime $date;

    public function __construct(string $username, string $message, ?\DateTime $date = null)
    {
        $this->username = $username;
        $this->message = $message;
        $this->date = $date ?: new \DateTime();
    }

    public function isValid(): bool
    {
        return empty($this->getErros());
    }

    public function getErros(): array
    {
        $errors = [];
        if (strlen($this->username) < self::LIMIT_USERNAME){
            $errors['username'] = 'Votre pseudo est trop court';
        }
        if (strlen($this->message) < self::LIMIT_USERNAME) {
            $errors['message'] = 'Votre message est trop court';
        }

        return $errors;
    }

    public function toHtml() : string 
    {
        $username = htmlentities($this->username);
        $date = $this->date->format('d/m/y à H:i');
        $message = nl2br(htmlentities($this->message));
        return <<<HTML
            <p class="m-2">
                <strong>$username: </strong> <em class="text-gray-300">le $date</em><br>
                $message
            </p>
HTML;
    }

    public function toJSON(): string
    {
        return json_encode([
            "username" => $this->username,
            "message" => $this->message,
            "date" => $this->date->getTimestamp()
        ]);
    } 
}