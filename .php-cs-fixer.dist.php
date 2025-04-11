<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude([
        'vendor',       // dependencias PHP (Composer)
        'node_modules', // dependencias JS
        //'storage',      // archivos de caché o logs (Laravel o similares)
        //'public',       // assets compilados (JS, CSS, imágenes)
        //'dist',         // salida de builds front-end (si aplica)
        //'build',        // igual que dist, pero usado por algunas herramientas
        //'coverage',     // resultados de code coverage
        '.git',         // repositorio Git
        '.vscode',      // configuración del editor
    ]);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        // Reglas clave para arrays bien indentados y separados
		// Array formatting
		'array_syntax' => ['syntax' => 'short'],
		'array_indentation' => true,
		'trailing_comma_in_multiline' => ['elements' => ['arrays']],
		'no_whitespace_before_comma_in_array' => true,
		'whitespace_after_comma_in_array' => true,

		// Otros formateos útiles
		'no_extra_blank_lines' => true,
    ])
    ->setIndent("\t") // indent_style = tab
    ->setLineEnding("\n"); // end_of_line = lf
