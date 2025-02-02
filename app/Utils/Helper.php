<?php

namespace App\Utils;

use Filament\Notifications\Notification;

class Helper
{
    public static function setGenericNotification(string $module, string $action): Notification
    {
        return Notification::make()
            ->success()
            ->title("{$module} deleted")
            ->body("The {$module} has been {$action} successfully.");
    }
}
