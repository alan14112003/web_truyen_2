<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StoryPinEnum extends Enum
{
    const EDITING = 0;
    const UPLOADING = 1;
    const APPROVE = 2;
}
