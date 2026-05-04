<?php

declare(strict_types=1);

namespace App\Library;

final class LibraryConfig
{
    public const DAILY_FINE_RATE = 5.0;
    public const DEFAULT_BORROW_DAYS = 14;
    public const STATUS_BORROWED = 'borrowed';
    public const STATUS_RETURNED = 'returned';
}

