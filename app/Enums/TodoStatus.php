<?php

namespace App\Enums;

enum TodoStatus: int
{
    case Pending = 0;
    case Processing = 1;
    case Completed = 2;
    case Canceled = 99;

    public function label(): string
    {
        return match($this) {
            self::Pending => '未着手',
            self::Processing => '進行中',
            self::Completed => '完了',
            self::Canceled => 'キャンセル',
        };
    }
}
