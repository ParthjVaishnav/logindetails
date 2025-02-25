<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Two-Factor Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }
        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0px 0px 20px rgba(255, 255, 255, 0.2);
        }
        .qr-container {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        input {
            border: none;
            padding: 10px;
            border-radius: 5px;
            outline: none;
            width: 100%;
            margin: 10px 0;
        }
        .btn-verify {
            background: #ff7eb3;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-verify:hover {
            background: #ff4f93;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <h2>Scan the QR Code to Enable 2FA</h2>
                    <div class="qr-container">
                        {!! $qrCodeImage !!}
                    </div>
                    <p>Alternatively, enter this key manually in Google Authenticator:</p>
                    <form action="{{ route('2fa.verify') }}" method="POST">
                        @csrf
                        <label for="code">Enter OTP:</label>
                        <input type="password" name="code" required>
                        <button type="submit" class="btn-verify">Verify</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
