<?php
//STRING HELPER
if ( ! function_exists('camel2words')) {
    /**
     * For example, 'PostTag' will be converted to 'Post Tag'.
     *
     * @param $name
     * @param bool $toLower
     *
     * @return string
     */
    function camel2words($name, $toLower = true)
    {
        $label = trim(str_replace([
            '-',
            '_',
            '.',
        ], ' ', preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $name)));

        return $toLower ? strtolower($label) : $label;
    }
}

if ( ! function_exists('humanize')) {
    /**
     * Returns a human-readable string from $word.
     * @param string $word the string to humanize
     * @param bool $ucAll whether to set all words to uppercase or not
     * @return string
     */
    function humanize($word, $ucAll = false)
    {
        $word = str_replace('_', ' ', preg_replace('/_id$/', '', $word));

        return $ucAll ? ucwords($word) : ucfirst($word);
    }
}

if ( ! function_exists('variablize')) {
    /**
     * Same as camelize but first char is in lowercase.
     * Converts a word like "send_email" to "sendEmail". It
     * will remove non alphanumeric character from the word, so
     * "who's online" will be converted to "whoSOnline"
     *
     * @param string $word to lowerCamelCase
     *
     * @return string
     */
    function variablize($word)
    {
        $word = studly_case($word);

        return strtolower($word[0]) . substr($word, 1);
    }
}

if ( ! function_exists('underscore')) {
    /**
     * Converts any "CamelCased" into an "underscored_word".
     * @param string $words the word(s) to underscore
     * @return string
     */
    function underscore($words)
    {
        return strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $words));
    }
}

if ( ! function_exists('camelize')) {
    /**
     * Returns given word as CamelCased.
     *
     * Converts a word like "send_email" to "SendEmail". It
     * will remove non alphanumeric character from the word, so
     * "who's online" will be converted to "WhoSOnline".
     * @see variablize()
     * @param string $word the word to CamelCase
     * @return string
     */
    function camelize($word)
    {
        return str_replace(' ', '', ucwords(preg_replace('/[^A-Za-z0-9]+/', ' ', $word)));
    }
}

if ( ! function_exists('formatBytes')) {
    /**
     * Format and convert "bytes" to its optimal higher metric unit
     *
     * @param double $bytes number of bytes
     * @param integer $precision the number of decimal places to round off
     *
     * @return string
     */
    function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow   = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow   = min($pow, count($units) - 1);

        $bytes /= $pow ** 1024;

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
//END STRING HELPER

//NUMBER HELPER
if ( ! function_exists('normalizeNUmber')) {
    /**
     * Normalizes a user-submitted number for use in code and/or to be saved into the database.
     *
     * @param $number
     * @param string $groupSymbol
     * @param string $decimalSymbol
     *
     * @return mixed
     */
    function normalizeNUmber($number, $groupSymbol = ',', $decimalSymbol = '.')
    {
        if (is_string($number)) {
            // Remove any group symbols and use a period for the decimal symbol
            $number = str_replace([$groupSymbol, $decimalSymbol], ['', '.'], $number);
        }

        return $number;
    }
}

if ( ! function_exists('getPercentage')) {
    /**
     * Returns percentage from number
     *
     * @param float $number
     * @param float $percents
     *
     * @return float
     */
    function getPercentage($number, $percents)
    {
        return $number / 100 * $percents;
    }
}

if ( ! function_exists('calculatePercentage')) {
    /**
     * Calculates percentage from two numbers
     *
     * @param float $original
     * @param float $new
     * @param bool $factor If enabled, `75%` will result in `0.75`.
     *
     * @return float
     */
    function calculatePercentage($original, $new, $factor = true)
    {
        $result = ($original - $new) / $original;
        if ( ! $factor) {
            $result *= 100;
        }

        return $result;
    }
}

if ( ! function_exists('increaseByPercentage')) {
    /**
     * Increase number by percents
     *
     * @param float $number
     * @param float $percents
     *
     * @return float
     */
    function increaseByPercentage($number, $percents)
    {
        return $number + getPercentage($number, $percents);
    }
}

if ( ! function_exists('decreaseByPercentage')) {
    /**
     * Increase number by percents
     *
     * @param float $number
     * @param float $percents
     *
     * @return float
     */
    function decreaseByPercentage($number, $percents)
    {
        return $number - getPercentage($number, $percents);
    }
}
//END NUMBER HELPER

if ( ! function_exists('isValueEmpty')) {
    /**
     * Returns a value indicating whether the give value is "empty".
     *
     * The value is considered "empty", if one of the following conditions is satisfied:
     *
     * - it is `null`,
     * - an empty string (`''`),
     * - a string containing only whitespace characters,
     * - or an empty array.
     *
     * @param mixed $value
     *
     * @return boolean if the value is empty
     */
    function isValueEmpty($value)
    {
        return $value === '' || $value === [] || $value === null || (\is_string($value) && trim($value) === '');
    }
}

if ( ! function_exists('isValueNotEmpty')) {
    /**-
     * Phủ định của isValueEmpty
     *
     * @param mixed $value
     *
     * @return boolean if the value is empty
     */
    function isValueNotEmpty($value)
    {
        return ! isValueEmpty($value);
    }
}

if ( ! function_exists('setEnvValue')) {
    /**
     * Thay đổi giá trị config trong file .env
     *
     * @param $envKey
     * @param $envValue
     */
    function setEnvValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str     = file_get_contents($envFile);

        $oldValue = env($envKey);

        $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);

        $fopen = fopen($envFile, 'wb');
        fwrite($fopen, $str);
        fclose($fopen);
    }
}

if ( ! function_exists('version')) {
    /**
     * Load asset có cache version
     *
     * @param $url
     *
     * @return string
     */
    function version($url)
    {
        $timestamp = \Illuminate\Support\Facades\Cache::get('asset_version');

        return asset($url . "?v={$timestamp}");
    }
}

if ( ! function_exists('user')) {
    /**
     * Get user đang đăng nhập
     *
     * @return string
     */
    function user()
    {
        return auth()->user();
    }
}