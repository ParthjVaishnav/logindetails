<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('css/otp_verification.css') }}">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: radial-gradient(circle, #111 30%, #222);
            font-family: 'Poppins', sans-serif;
            color: white;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 25px;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 12px;
            box-shadow: 0px 0px 20px rgba(0, 255, 255, 0.2);
            text-align: center;
        }

        h1 {
            font-size: 24px;
            color: #0ef;
            text-transform: uppercase;
        }

        p {
            font-size: 14px;
            color: #ddd;
        }

        .input-group {
            margin: 20px 0;
        }

        input {
            width: 100%;
            padding: 12px;
            background: #222;
            border: 2px solid transparent;
            border-radius: 8px;
            color: #0ef;
            font-size: 16px;
            text-align: center;
        }

        input:focus {
            border-color: #0ef;
            outline: none;
        }

        .verify-btn {
            background: linear-gradient(45deg, #0ef, #09f);
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-transform: uppercase;
            font-weight: bold;
        }

        .verify-btn:disabled {
            background: #555;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>OTP Verification</h1>
        <p>Enter the OTP sent to your email address.</p>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form action="{{ route('otp.verifys') }}" method="POST" id="otpForm">
            @csrf
            <div class="input-group">
                <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
            </div>
            <button type="submit" class="verify-btn" id="verifyBtn" disabled>Verify OTP</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            const otpInput = $('#otp');
            const verifyBtn = $('#verifyBtn');

            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right"
            };

            function validateOTP() {
                const otpValue = otpInput.val().trim();
                const isValidOTP = /^\d{6}$/.test(otpValue);
                verifyBtn.prop('disabled', !isValidOTP);
            }

            otpInput.on('input', validateOTP);
        });
    </script>
</body>

</html>
