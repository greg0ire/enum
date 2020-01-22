<?php

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PHP71Migration' => true,
        '@PSR2' => true,
        '@Symfony' => true,
        'align_multiline_comment' => true,
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'binary_operator_spaces' => [
            'operators' => [
                '=>' => 'single_space',
                '=' => 'single_space',
            ],
        ],
        'combine_consecutive_unsets' => true,
        'linebreak_after_opening_tag' => true,
        'list_syntax' => [
            'syntax' => 'short',
        ],
        'no_empty_statement' => true,
        'no_extra_consecutive_blank_lines' => [
            'tokens' => [
                'break',
                'continue',
                'extra',
                'return',
                'throw',
                'use',
                'parenthesis_brace_block',
                'square_brace_block',
                'curly_brace_block',
            ],
        ],
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_whitespace_in_blank_line' => true,
        'object_operator_without_whitespace' => true,
        'ordered_imports' => true,
        'space_after_semicolon' => true,
        'single_line_throw' => false,
        'standardize_not_equals' => true,
        'trailing_comma_in_multiline_array' => true,
        'visibility_required' => [
            'const',
            'method',
            'property',
        ],
        'yoda_style' => [
            'equal' => false,
            'identical' => false,
        ],
    ])
    ->setUsingCache(true)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in([
                __DIR__.'/src',
            ])
    );
