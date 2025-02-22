<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Two-Factor Authentication</title>
</head>
<body>
    <h2>Scan the QR Code to Enable 2FA</h2>
    
    <!-- Display QR Code -->
    <div>
        {!! $qrCodeImage !!}
    </div>

    <p>Alternatively, enter this key manually in Google Authenticator:</p>
    

    <form action="{{ route('2fa.verify') }}" method="POST">
        @csrf
        <label for="code">Enter OTP:</label>
        <input type="text" name="code" required>
        <button type="submit">Verify</button>
    </form>
</body>
</html>
