<?php

namespace Config;

class CustomValidation
{
    public function no_repeating_chars(string $str, string $fields, array $data): bool
    {
        // Your validation logic here
        return !preg_match('/([a-zA-Z0-9])\1\1/', $str);
    }
}
