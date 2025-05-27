<?php

namespace App\Enums;

enum TodoStatus: int
{
    case Pending = 0;
    case Processing = 1;
    case Completed = 2;
    case Canceled = 99;
}
