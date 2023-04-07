<?php

namespace App\Logging;
use Illuminate\Support\Arr;
use Monolog\Formatter\LineFormatter;

class CustomFormatter
{
    public function __invoke( $log )
    {
        foreach ( $log->getHandlers() as $handle ) {
            $handle->setFormatter(new LineFormatter(
                "[%datetime%] [%level_name%] %message% %context%\n","d-m-Y H:i:s", true, true
            ), function ( $formatter ) {
                $formatter->includeStacktraces();
            });
        }
    }
}
