<?php

namespace App\Services\Notifications;

use App\Models\Student;

interface INotificationService
{
    public function sendRegistrationNotification(Student $student): void;
}