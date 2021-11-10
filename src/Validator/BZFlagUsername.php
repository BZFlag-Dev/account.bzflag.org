<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class BZFlagUsername extends Constraint
{
    public $min_length = 2;
    public $max_length = 31;

    public $message_too_short = 'The username must be at least {{ min_length }} characters long.';
    public $message_too_long = 'The username must be at most {{ max_length }} characters long.';
    public $message_invalid_whitespace = 'The username contains leading or trailing whitespace, whitespaces other than spaces, or consecutive spaces.';
    public $message_invalid_chars = 'The username can only contain standard printable ASCII characters excluding quotes';
    public $message_spoofing_chars = 'The username must not start with +, @, >, or #.';
    public $message_unreadable = 'The username must contain mostly letters and numbers.';
}
