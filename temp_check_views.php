<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check if views compile without errors
$views = [
    'member.dashboard',
    'member.membership.card',
    'member.profile.show',
];

foreach ($views as $view) {
    try {
        $compiled = view($view)->render();
        echo "$view: Compiled successfully (" . strlen($compiled) . " bytes)" . PHP_EOL;
        
        // Check for key content
        $checks = [
            'Dashboard' => ['Recent Activity', 'Quick Services', 'Metric Cards'],
            'Card' => ['Print Card', 'Membership Details', 'EDAA-KNGC'],
            'Profile' => ['Profile Strength', 'Academic Heritage', 'Professional Journey'],
        ];
        
        if (isset($checks[$view])) {
            foreach ($checks[$view] as $check) {
                $found = strpos($compiled, $check) !== false;
                echo "  - $check: " . ($found ? 'FOUND' : 'MISSING') . PHP_EOL;
            }
        }
    } catch (Throwable $e) {
        echo "$view: ERROR - " . $e->getMessage() . PHP_EOL;
    }
}
