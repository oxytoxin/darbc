<?php

use Filament\Notifications\Notification;

if (!function_exists('ordinal')) {
    function ordinal($number)
    {
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13))
            return $number . 'th';
        else
            return $number . $ends[$number % 10];
    }
}

if (!function_exists('notify')) {
    function notify($title = 'Success.', $body = null, $type = 'success')
    {
        $notification = Notification::make()->title($title);
        if ($body) {
            $notification->body($body);
        }
        switch ($type) {
            case 'success':
                $notification->body($body)->success();
                break;
            case 'warning':
                $notification->body($body)->warning();
                break;
            case 'danger':
                $notification->body($body)->danger();
                break;
            default:
                break;
        }
        $notification->send();
    }
}

if (!function_exists('float2rat')) {
    function float2rat($n, $tolerance = 1.e-6)
    {
        if (!floatval($n)) {
            return [0, 1];
        }
        $h1 = 1;
        $h2 = 0;
        $k1 = 0;
        $k2 = 1;
        $b = 1 / $n;
        do {
            $b = 1 / $b;
            $a = floor($b);
            $aux = $h1;
            $h1 = $a * $h1 + $h2;
            $h2 = $aux;
            $aux = $k1;
            $k1 = $a * $k1 + $k2;
            $k2 = $aux;
            $b = $b - $a;
        } while (abs($n - $h1 / $k1) > $n * $tolerance);

        return [$h1, $k1];
    }
}
