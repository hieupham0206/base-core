<?php

namespace Cloudteam\BaseCore\Utils;

class Inflector
{
    private const DICTIONARY = [
        0                   => 'không',
        1                   => 'một',
        2                   => 'hai',
        3                   => 'ba',
        4                   => 'bốn',
        5                   => 'năm',
        6                   => 'sáu',
        7                   => 'bảy',
        8                   => 'tám',
        9                   => 'chín',
        10                  => 'mười',
        11                  => 'mười một',
        12                  => 'mười hai',
        13                  => 'mười ba',
        14                  => 'mười bốn',
        15                  => 'mười năm',
        16                  => 'mười sáu',
        17                  => 'mười bảy',
        18                  => 'mười tám',
        19                  => 'mười chín',
        20                  => 'hai mươi',
        30                  => 'ba mươi',
        40                  => 'bốn mươi',
        50                  => 'năm mươi',
        60                  => 'sáu mươi',
        70                  => 'bảy mươi',
        80                  => 'tám mươi',
        90                  => 'chín mươi',
        100                 => 'trăm',
        1000                => 'nghìn',
        1000000             => 'triệu',
        1000000000          => 'tỷ',
        1000000000000       => 'nghìn', //ngìn tỷ
        1000000000000000    => 'nghìn triệu triệu',
        1000000000000000000 => 'tỷ tỷ',
    ];
    private static $seperator = ' ';

    public static function numberToWord($number)
    {
        $number = str_replace(',', '', $number);

        if ( ! is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            trigger_error(
                'only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );

            return false;
        }

        if ($number < 0) {
            return 'âm ' . self::numberToWord(abs($number));
        }

        return self::processNumber($number);
    }

    private static function processNumber($number)
    {
        $fraction = null;

        if (strpos($number, '.') !== false) {
            [$number, $fraction] = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = self::DICTIONARY[$number];
                break;
            case $number < 100:
                $string = self::generateOnes($number);
                break;
            case $number < 1000:
                $string = self::generateHundred($number);
                break;
            default:
                $string = self::generateBeyondThoundsand($number);
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= ' phẩy ';
            $words  = [];
            foreach (str_split((string) $fraction) as $num) {
                $words[] = self::DICTIONARY[$num];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

    private static function generateOnes($number): string
    {
        $tens   = ((int) ($number / 10)) * 10;
        $units  = $number % 10;
        $string = self::DICTIONARY[$tens];
        if ($units) {
            $tmpText = self::$seperator . self::DICTIONARY[$units];
            if ($units == 1) {
                $tmpText = self::$seperator . 'mốt';
            } elseif ($units == 5) {
                $tmpText = self::$seperator . 'lăm';
            }
            $string .= $tmpText;
        }

        return $string;
    }

    private static function generateHundred($number): string
    {
        $hundreds  = $number / 100;
        $remainder = $number % 100;
        $string    = self::DICTIONARY[$hundreds] . ' ' . self::DICTIONARY[100];
        if ($remainder) {
            $tmpText = self::$seperator . self::numberToWord($remainder);
            if ($remainder < 10) {
                $tmpText = self::$seperator . 'lẻ ' . self::numberToWord($remainder);
            } elseif ($remainder % 10 == 5) {
                $tmpText = self::$seperator . self::numberToWord($remainder - 5) . ' lăm';
            }

            $string .= $tmpText;
        }

        return $string;
    }

    private static function generateBeyondThoundsand($number): string
    {
        $baseUnit         = 1000 ** floor(log($number, 1000));
        $numBaseUnits     = (int) ($number / $baseUnit);
        $remainder        = $number % $baseUnit;
        $hundredRemainder = ($remainder / $baseUnit) * 1000;

        $string = self::numberToWord($numBaseUnits) . ' ' . self::DICTIONARY[$baseUnit];
        if ($remainder < 100 && $remainder > 0) {
            $string = self::numberToWord($numBaseUnits) . ' ' . self::DICTIONARY[$baseUnit] . ' không trăm';
            if ($remainder < 10) {
                $string = self::numberToWord($numBaseUnits) . ' ' . self::DICTIONARY[$baseUnit] . ' không trăm lẻ';
            }
        } elseif ($hundredRemainder > 0 && $hundredRemainder < 100) {
            $string = self::numberToWord($numBaseUnits) . ' ' . self::DICTIONARY[$baseUnit] . ' không trăm';
            if ($hundredRemainder < 10) {
                $string = self::numberToWord($numBaseUnits) . ' ' . self::DICTIONARY[$baseUnit] . ' không trăm lẻ';
            }
        }

        if ($remainder) {
            $string .= self::$seperator . self::numberToWord($remainder);
        }

        return $string;
    }

    /**
     * Normalizes a user-submitted number for use in code and/or to be saved into the database.
     *
     * @param $number
     * @param string $groupSymbol
     * @param string $decimalSymbol
     *
     * @return mixed
     */
    public static function normalizeNUmber($number, $groupSymbol = ',', $decimalSymbol = '.')
    {
        if (is_string($number)) {
            // Remove any group symbols and use a period for the decimal symbol
            $number = str_replace([$groupSymbol, $decimalSymbol], ['', '.'], $number);
        }

        return $number;
    }
}