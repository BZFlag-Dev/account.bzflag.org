<?php
/*
 * BZFlag Accounts - Manage accounts and organizations for BZFlag
 * Copyright (C) 2021  BZFlag & Associates
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

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
