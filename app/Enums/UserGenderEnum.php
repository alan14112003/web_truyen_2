<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;


final class UserGenderEnum extends Enum
{
    public const FEMALE = 0;
    public const MALE = 1;
    public const LES = 2;
    public const GAY = 3;


    public static function getArrayView() {
        return [
            'Nữ' => self::FEMALE,
            'Nam' => self::MALE,
            'Les' => self::LES,
            'Gay' => self::GAY,
        ];
    }
    public static function getNameByValue($value) {
        return array_search($value, self::getArrayView(), true);
    }
}
