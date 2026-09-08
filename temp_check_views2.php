<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Simulate a logged-in member
$user = App\Models\User::where('email', 'johirul.shovon@edaa.kngc.edu')->first();
if (!$user) {
    die("User not found\n");
}

Auth::login($user);
$alumni = $user->alumni;
$membership = $alumni->membership;

// Render dashboard with proper data
try {
    $html = view('member.dashboard', [
        'alumni' => $alumni,
        'membership' => $membership,
        'recentPayments' => $membership->payments()->latest('paid_at')->limit(5)->get(),
        'outstandingBalance' => 0,
        'totalPaid' => 0,
        'rank' => null,
    ])->render();
    
    // Save to file for inspection
    file_put_contents('dashboard_output.html', $html);
    echo "Dashboard rendered: " . strlen($html) . " bytes\n";
    echo "Saved to dashboard_output.html\n";
    
    // Check for key sections
    $checks = ['Recent Activity', 'Quick Services', 'Membership', 'Edit Profile', 'Card', 'Payments', 'Security', 'Public Profile', 'Privacy'];
    foreach ($checks as $check) {
        $found = strpos($html, $check) !== false;
        echo "  - $check: " . ($found ? 'FOUND' : 'MISSING') . "\n";
    }
    
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
