<?php

namespace App\Helpers;


trait ErrorJsonChanger
{
    public function arrayToJsonChanger($messages)
    {
        $errors  = [];
        foreach ($messages as $key => $message) {
            $errors[$key] = $message[0];
        }
        return $errors;
    }
}
