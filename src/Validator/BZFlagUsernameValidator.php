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
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class BZFlagUsernameValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof BZFlagUsername) {
            throw new UnexpectedTypeException($constraint, BZFlagUsername::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }


        // NOTE: phpBB checks for the username length, which is set in ACP
        if (strlen($value) < $constraint->min_length) {
            $this->context->buildViolation($constraint->message_too_short)
                ->setParameter('{{ min_length }}', $constraint->min_length)
                ->addViolation()
            ;
        }
        // Max length is 32 including the terminating NUL
        else if (strlen($value) > $constraint->max_length) {
            $this->context->buildViolation($constraint->message_too_long)
                ->setParameter('{{ max_length }}', $constraint->max_length)
                ->addViolation()
            ;
        }


        // Don't allow leading or trailing whitespace
        if (ctype_space(substr($value, 0, 1)) || ctype_space(substr($value, -1))) {
            $this->context->buildViolation($constraint->message_invalid_whitespace)
                ->addViolation()
            ;
        }

        // Block spoofing names
        if (in_array(substr($value, 0, 1), ['+', '@', '#'])) {
            $this->context->buildViolation($constraint->message_spoofing_chars)
                ->addViolation()
            ;
        }

        // Start with true to reject leading space
        $lastWasSpace = true;
        $alnumCount = 0;
        for ($i = 0; $i < strlen($value); $i++)
        {
            $char = substr($value, $i, 1);

            // Reject leading and sequential spaces
            if ($lastWasSpace && ctype_space($char)) {
                $this->context->buildViolation($constraint->message_invalid_whitespace)
                    ->addViolation()
                ;
            }

            // Reject ' and " and any non-printable
            // NOTE: phpBB's validate_username function checks for double quotes
            if ($char == "'" || $char == '"' || !ctype_print($char)) {
                $this->context->buildViolation($constraint->message_invalid_chars)
                    ->addViolation()
                ;
            }

            // Handle non-ASCII in case phpBB isn't set right
            if (ord($char) > 0x7f) {
                $this->context->buildViolation($constraint->message_invalid_chars)
                    ->addViolation()
                ;
            }

            // Only space is valid whitespace
            // NOTE: ctype_print might make this whitespace check pointless
            if (ctype_space($char)) {
                if ($char != ' ') {
                    $this->context->buildViolation($constraint->message_invalid_whitespace)
                        ->addViolation()
                    ;
                }
                $lastWasSpace = true;
            } else {
                $lastWasSpace = false;
                if (ctype_alnum($char))
                    $alnumCount++;
            }
        }

        $readable = ($alnumCount / strlen($value)) > 0.5;
        if (!$readable) {
            $this->context->buildViolation($constraint->message_unreadable)
                ->addViolation()
            ;
        }
    }
}
