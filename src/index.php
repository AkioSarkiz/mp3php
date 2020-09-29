<?php

require __DIR__ . '/../vendor/autoload.php';

function show_phpunit(): void
{
    $dir = realpath(__DIR__ . '/../');
    echo '<pre>';
    echo shell_exec("cd $dir && php vendor/bin/phpunit");
}

show_phpunit();