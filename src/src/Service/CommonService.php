<?php

namespace App\Service;

class CommonService
{
    public function getValidationErrorMessages($errors): array
    {
        $errorMessages = [];
        foreach ($errors as $error) { 
            $errorMessages[] = $error->getPropertyPath() . ': ' . $error->getMessage();
        }

        return $errorMessages;
    }  
}