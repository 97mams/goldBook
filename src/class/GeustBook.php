<?php
namespace App\class;

use DateTime;

class GeustBook
{
    private $file;

    public function __construct(string $file)
    {
        $directory = dirname($file);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        if (!file_exists($file)) {
            touch($file);
        }
        $this->file = $file;
    }

    public function addMessage(Message $message) : void
    { 
        //PHP_EOL saut de ligne equivalant \n
        file_put_contents($this->file, $message->toJSON() . PHP_EOL, FILE_APPEND);
    }

    public function getMessage(): array
    {
        //trim pour enlever le vide avant et apres la contenu
        $content = trim(file_get_contents($this->file));
        // reccuper par ligne
        $lines = explode(PHP_EOL, $content);
        $messages = [];
        foreach($lines as $line) {
            $data = json_decode($line, true);
            $messages[]  = new Message($data["username"], $data["message"], new DateTime('@'. $data['date']));
        }
        return array_reverse($messages);
    }
}