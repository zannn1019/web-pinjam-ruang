<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StatusRuangan extends Enum
{
    const Kosong = 0;
    const Booking = 1;
    const Digunakan = 2;
    const Perbaikan = 3;
}
