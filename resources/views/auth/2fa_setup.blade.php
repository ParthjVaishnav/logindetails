<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Two-Factor Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: #ECE5DD;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 400px;
            width: 100%;
            background: #FFFFFF;
            border-radius: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }
        .header {
            background: #25D366;
            color: white;
            padding: 15px;
            border-radius: 15px 15px 0 0;
            font-size: 18px;
            font-weight: bold;
        }
        .qr-container {
            padding: 20px 0;
        }
        .form-control {
            border-radius: 25px;
            border: 1px solid #D1D1D1;
            padding: 12px;
            font-size: 16px;
        }
        .btn-verify {
            background: #25D366;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 25px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-verify:hover {
            background: #1EBE57;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Two-Step Verification</div>
        <div class="qr-container">
            {!! $qrCodeImage !!}
        </div>
        <p>Scan the QR code with Google Authenticator or enter this key manually:</p>
        <form action="{{ route('2fa.verify') }}" method="POST">
            @csrf
            <label for="code" class="form-label">Enter OTP:</label>
            <input type="password" name="code" class="form-control" required>
            <button type="submit" class="btn-verify mt-3">Verify</button>
        </form>
    </div>
</body>
</html>
