<?php
namespace App\classes\Validator;
class GeneralValidator {
    public static function bi($value)
    {
        $pattern = '/^\d{9}[A-z]{2}0\d{2}$/i';
        return preg_match($pattern, (string) $value);
    }
    
    public static function required($value)
    {
        return !empty($value);
    }

    public static function email($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

   
    public static function minLength($value, $min)
    {
        return strlen((string) $value) >= $min;
    }

    public static function maxLength($value, $max)
    {
        return strlen((string) $value) <= $max;
    }

    public static function numeric($value)
    {
        return is_numeric($value);
    }

    public static function integer($value)
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    public static function decimal($value)
    {
        return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
    }

    public static function between($value, $min, $max)
    {
        return $value >= $min && $value <= $max;
    }

    public static function url($value)
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }

    public static function date($value, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $value);
        return $d && $d->format($format) === $value;
    }

    public static function alpha($value)
    {
        return ctype_alpha((string) $value);
    }

    public static function alphaNumeric($value)
    {
        return ctype_alnum((string) $value);
    }

    public static function alphaNumericSpace($value)
    {
        return preg_match('/^[a-zA-Z0-9\s]+$/', (string) $value);
    }

    public static function ip($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    }

    public static function ipv4($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    public static function ipv6($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }

    public static function phone($value)
    {
        return preg_match('/^\+?[0-9\s\-\(\)]+$/', (string) $value);
    }

    public static function regex($value, $pattern)
    {
        return preg_match($pattern, (string) $value);
    }

     public static function compare($value, $confirm)
    {
        return $value === $confirm;
    }

}