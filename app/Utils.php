<?php
namespace App;

class Utils
{
    /**
     * convert seconds to aother units
     * @param $seconds {integer} seconds will be converted
     * @param $format {string} the format want convert, Y as year, K as month,
     *     D as day, M as minute, S as second. format follow this order
     */
    public static function secondsTo($seconds, $format = 'HM')
    {
        $result = '';

        $format = str_split($format);
        foreach($format as $f) {
            switch ($f) {
                case 'Y':
                    $years = floor($seconds / (3600 * 24 * 365));
                    $seconds %= 3600 * 24 * 365;
                    if ($years > 0) {
                        $result .= $years . ' ' . trans('misc.year') . ' ';
                    }
                    break;
                case 'K':
                    $months = floor($seconds / (3600 * 24 * 30));
                    $seconds %= 3600 * 24 * 30;
                    if ($months > 0) {
                        $result .= $months . ' ' . trans('misc.month') . ' ';
                    }
                    break;
                case 'D':
                    $days = floor($seconds / (3600 * 24));
                    $seconds %= 3600 * 24;
                    if ($days > 0) {
                        $result .= $days . ' ' . trans('misc.day') . ' ';
                    }
                    break;
                case 'H':
                    $hours = floor($seconds / 3600);
                    $seconds %= 3600;
                    if ($hours > 0) {
                        $result .= $hours . ' ' . trans('misc.hour') . ' ';
                    }
                    break;
                case 'M':
                    $minutes = floor($seconds / 60);
                    $seconds %= 60;
                    if ($minutes > 0) {
                        $result .= $minutes . ' ' . trans('misc.minute') . ' ';
                    }
                    break;
                case 'S':
                    if ($seconds > 0) {
                        $result .= $seconds . ' ' . trans('misc.second') . ' ';
                    }
                    break;
                default:
                    break;
            }
        }

        return rtrim($result);
    }
    /**
     * Get size(3K/2M/1G) in bytes
     * @param $size {string}
     * @return {number} size in bytes
     */
    public static function getSizeInBytes($size)
    {
        $size = trim($size);
        $modifier = strtolower($size[strlen($size) - 1]);
        $size = intval($size);
        switch ($modifier) {
            case 'g':
                $size *= 1024;
            case 'm':
                $size *= 1024;
            case 'k':
                $size *= 1024;
                break;
            default:
                throw new \Exception('Unknown byte modifier '.$modifier);
        }

        return $size;
    }
}
