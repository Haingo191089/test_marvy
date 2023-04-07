<?php

echo "***********************************************************\n";
echo "***********************************************************\n";
echo "****             COMMANDS                              ****\n";
echo "**** clear       clear cache for app                   ****\n";
echo "**** build       generate key, migrate, seed DB        ****\n";
echo "**** start       run app at develop mode               ****\n";
echo "***********************************************************\n";
echo "***********************************************************\n";

while (true) {
    $keyInput = readline("Keypress: ");
    switch ($keyInput) {
        case "clear":
            echo shell_exec(join(" && ", [
                "php artisan route:clear",
                "php artisan view:clear",
                "php artisan cache:clear",
                "php artisan config:clear",
                "php artisan env",
            ]));
            echo "Clear::Done!!!!\n";
            break;
        case "build":
            echo shell_exec(join(" && ", [
                "composer install",
                "php artisan config:clear",
                "php artisan cache:clear",
                "php artisan env",
                "php artisan key:generate",
                "php artisan migrate",
                "php artisan db:seed",
                "composer dump-autoload",
            ]));
            echo "build::Done!!!!\n";
            break;
        case "start":
            echo shell_exec(join(" && ", [
                "php artisan serve",
            ]));
            echo "start::Done!!!!\n";
            break;
        case "exit":
            return;
        default:
            echo "Input Command not true\n";
            break;
    }
}
