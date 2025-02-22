<!DOCTYPE html>
<html>
<head>
    <title>New Login Alert</title>
</head>
<body>
    <p>Hello {{ $user->name }},</p>
    <p>A new login was detected on your account:</p>
    <ul>
        <li><strong>IP Address:</strong> {{ $ipAddress }}</li>
        <li><strong>Device:</strong> {{ $device }}</li>
    </ul>
    <p>If this was you, no action is needed.</p>
    <p>If you did not log in, <strong>please reset your password immediately.</strong></p>
    <p>Stay safe!</p>
</body>
</html>
