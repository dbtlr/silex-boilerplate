<?php

function pre_r($var)
{
    $args = func_get_args();

    foreach ($args as $var) {
        echo '<pre>' . print_r($var, true) . '</pre>';
    }
}


function backtrace($backtrace=null)
{
    if (!isset($backtrace)) {
        $backtrace = debug_backtrace();
        array_shift($backtrace);
    }

    $backtraceOut = '';
    $enableFor    = array('include', 'include_once', 'require', 'require_once');

    foreach ($backtrace as $event) {
        $arguments = '';

        // disable argument output for all but the listed functions.
        // if ( in_array( $event['function'], $enableFor ) && isset ( $event['args'] ) ) {
        //     $arguments = ArrayUtils::toArgString( $event['args'], true );
        // }

        if (isset($event['file']) && isset($event['line'])) {
            $backtraceOut .= 'File: ' . $event['file'] . ' Line: ' . $event['line'] . "\n";
        }

        $backtraceOut .= (isset($event['class']) ? $event['class'] . $event['type'] : '')
                      . $event['function'] . '(' . $arguments . ")\n\n";
    }

    return trim($backtraceOut);
}