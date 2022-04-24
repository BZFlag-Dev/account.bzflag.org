<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('bin/')
    ->exclude('var/')
    ->exclude('vendor/')
    ->exclude('config/')
    ->exclude('public/')
    ->notPath('src/Kernel.php')
    ->notPath('tests/bootstrap.php')
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
return $config
    ->setRules([
        '@Symfony' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'new_line_for_chained_calls',
        ],
        'control_structure_continuation_position' => [
            'position' => 'next_line',
        ],
        'no_whitespace_in_blank_line' => true,
        'declare_strict_types' => true,
        'header_comment' => [
            'comment_type' => 'comment',
            'location' => 'after_declare_strict',
            'separate' => 'bottom',
            'header' =>
'BZFlag Accounts - Manage accounts and organizations for BZFlag
Copyright (C) 2022  BZFlag & Associates

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.'
        ]
    ])
    ->setFinder($finder)
;
