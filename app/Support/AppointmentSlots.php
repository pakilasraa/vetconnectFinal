<?php

namespace App\Support;

final class AppointmentSlots
{
    /**
     * Canonical bookable times (one appointment per slot; matches conflict rules in AppointmentController).
     *
     * @return list<string> H:i:s
     */
    public static function times(): array
    {
        return [
            '09:00:00',
            '10:00:00',
            '11:00:00',
            '13:00:00',
            '14:00:00',
            '15:00:00',
            '16:00:00',
        ];
    }
}
