<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Escape LIKE wildcard characters in user input to prevent pattern manipulation.
     */
    protected function escapeLike(string $value): string
    {
        return str_replace(['%', '_'], ['\%', '\_'], $value);
    }
}
