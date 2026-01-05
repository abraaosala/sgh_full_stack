<?php

declare(strict_types=1);

namespace App\classes;

class Config
{
    public function title($title = '', $sistem='')
    {
                /* <?= $title ?? '' ?> - <?= $sistem ?? '' ?> */
$str = $title;
if (!empty($title)) {
    $str .= " | ";
}

return $str . $sistem;
}
}