<?php
if (!function_exists('__tr')) {
    /**
     * String translations for gettext
     *
     * @param string $string
     * @param array $replaceValues
     * @return string
     */
    function __tr(string $string, array $replaceValues = []):string
    {
        $string = e(T_gettext($string));

        // Check if replaceValues exist
        if (!empty($replaceValues) and is_array($replaceValues)) {
            $string = strtr($string, $replaceValues);
        }

        // if numbers found in string change those also.
        $string = preg_replace_callback('!\d+!', function ($matches) {
            if (class_exists('NumberFormatter')) {
                $numberFormatter = new NumberFormatter(
                    defined('CURRENT_LOCALE') ? CURRENT_LOCALE : 'en_US',
                    NumberFormatter::IGNORE
                );
                return $numberFormatter->format($matches[0]);
            }
        }, $string);

        unset($matches);

        return $string;
    }
}

if (!function_exists('__trn')) {
    /**
     * Translation for Plurals 
     *
     * @param string $string
     * @param string $string2
     * @param integer $int
     * @param array $replaceValues
     * @return string
     */
    function __trn(string $string, string $string2 = '', int $int = 1, array $replaceValues = []):string
    {
        $int = (int) $int;
        $string = e(T_ngettext($string, $string2, $int));
        // Check if replaceValues exist
        if (!empty($replaceValues) and is_array($replaceValues)) {
            $string = strtr($string, $replaceValues);
        }

        // if numbers found in string change those also.
        $string = preg_replace_callback('!\d+!', function ($matches) {
            if (class_exists('NumberFormatter')) {
                $numberFormatter = new NumberFormatter(
                    CURRENT_LOCALE,
                    NumberFormatter::IGNORE
                );
                return $numberFormatter->format($matches[0]);
            }
        }, $string);

        unset($matches);

        return $string;
    }
}
