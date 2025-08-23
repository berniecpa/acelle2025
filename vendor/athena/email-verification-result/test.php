<?php
require __DIR__ . '/vendor/autoload.php';

use Athena\EmailVerificationResult;

$result = new EmailVerificationResult([
    'status' => 'deliverable',
    'mxs' => [
        'smtp.google.com - 10',
        'alt1.gmail-smtp-in.l.google.com - 10',
        'alt2.gmail-smtp-in.l.google.com - 20',
    ],
    'first_name' => 'Luan',
    'last_name' => null,
]);

echo "{$result->getStatus()}\n";
echo json_encode($result->getMxs()) . "\n";