<?php

namespace App\Services;

class ValidationService
{
    public static function validate(array $data, array $rules): array
    {
        $errors = [];
        foreach ($rules as $field => $rule) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $errors[$field] = "The {$field} field is required";
                continue;
            }

            if ($rule === 'email' && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = "The {$field} must be a valid email address";
            }
        }
        return $errors;
    }
}
