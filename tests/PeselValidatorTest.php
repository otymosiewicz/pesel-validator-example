<?php declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class PeselValidatorTest extends TestCase
{
    public static function getInvalidValues(): array
    {
        return [
            ['00000000000'],
            ['12345678901'],
            ['abcdefghijk'],
            ['92021312345'],
            ['00123123456'],
            ['99123012345'],
            ['01010123456'],
            ['99023012345'],
            ['0012312345'],
            ['12345678900'],
        ];
    }

    public static function getValidValues(): array
    {
        return [
            ['56021263669'],
            ['74012684963'],
            ['97090511671'],
            ['53061259696'],
            ['73090626564'],
            ['75050182433'],
            ['61062198878'],
            ['75092491872'],
            ['05272997621'],
            ['83031343155'],
        ];
    }

    #[DataProvider('getValidValues')]
    public function testValidPesels($value)
    {
        self::assertTrue(PeselValidator::validate($value));
    }

    #[DataProvider('getInvalidValues')]
    public function testInvalidPesels($value)
    {
        self::assertFalse(PeselValidator::validate($value));
    }
}

