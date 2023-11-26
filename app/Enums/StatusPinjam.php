<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StatusPinjam extends Enum
{
    const Menunggu_Konfirmasi = 0;
    const Terima = 1;
    const Tolak = 2;
    const Selesai = 3;
}
