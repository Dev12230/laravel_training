<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Artical()
 * @method static static News()
 */
final class NewsType extends Enum
{
    const Artical =1;
    const News =2;
}
