<?php

class PeselValidator implements ValidatorInterface
{
    private const WEIGHTS = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3, 1];

    public static function validate(mixed $value): bool
    {
        if (!self::hasValidFormat($value)) {
            return false;
        }

        if (!self::hasValidChecksum($value)) {
            return false;
        }

        if (!self::hasValidBirthDate($value)) {
            return false;
        }

        return true;
    }

    private static function hasValidFormat(mixed $value): bool
    {
        return preg_match('/^\d{11}$/', $value);
    }

    private static function hasValidChecksum(string $value): bool
    {
        $digits = str_split($value);
        $checksum = 0;

        foreach ($digits as $index => $digit) {
            $checksum += self::WEIGHTS[$index] * intval($digit);
        }

        return $checksum % 10 === 0;
    }

    private static function hasValidBirthDate(string $value): bool
    {
        $monthDigits = intval(self::getMonthDigits($value));
        $dayDigits = self::getDayDigits($value);
        $yearDigits = self::getYearDigits($value);

        return match (true) {
            $monthDigits >= 81 && $monthDigits <= 92 => checkdate($monthDigits - 80, $dayDigits, '18'.$yearDigits),
            $monthDigits > 0 && $monthDigits <= 12 => checkdate($monthDigits, $dayDigits, '19'.$yearDigits),
            $monthDigits >= 21 && $monthDigits <= 32 => checkdate($monthDigits - 20, $dayDigits, '20'.$yearDigits),
            default => false,
        };
    }

    private static function getMonthDigits(string $value): string
    {
        return substr($value, 2, 2);
    }

    private static function getDayDigits(string $value): string
    {
        return substr($value, 4, 2);
    }

    private static function getYearDigits(string $value): string
    {
        return substr($value, 0, 2);
    }
}