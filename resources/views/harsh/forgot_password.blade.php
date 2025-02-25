<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="{{ asset('css/forgot_password.css') }}">

    <style>
        /* Global Styles */
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: radial-gradient(circle, #111 30%, #222);
            font-family: 'Poppins', sans-serif;
            color: white;
        }

        /* Container */
        .container {
            width: 100%;
            max-width: 420px;
            padding: 25px;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 12px;
            box-shadow: 0px 0px 20px rgba(0, 255, 255, 0.2);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        /* Title */
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #0ef;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        p {
            font-size: 14px;
            color: #ddd;
        }

        /* Input Field */
        .input-group {
            position: relative;
            margin: 20px 0;
        }

        input[type="email"] {
            width: 100%;
            padding: 12px;
            background: #222;
            border: 2px solid transparent;
            border-radius: 8px;
            color: #0ef;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #0ef;
            outline: none;
            box-shadow: 0px 0px 10px rgba(0, 238, 255, 0.5);
        }

        label {
            position: absolute;
            top: 14px;
            left: 15px;
            color: #888;
            transition: 0.3s ease;
        }

        input:focus + label,
        input:not(:placeholder-shown) + label {
            top: -12px;
            left: 10px;
            font-size: 12px;
            color: #0ef;
            background: #222;
            padding: 2px 5px;
            border-radius: 4px;
        }

        /* Button */
        .btn {
            background: linear-gradient(45deg, #0ef, #09f);
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .btn:hover {
            background: linear-gradient(45deg, #09f, #0ef);
            box-shadow: 0px 0px 15px rgba(0, 238, 255, 0.5);
        }

        .btn:disabled {
            background: #555;
            cursor: not-allowed;
        }

        /* Loading Screen */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            z-index: 1000;
        }

        /* Loader Animation */
        .loader {
            width: 60px;
            height: 60px;
            border: 6px solid rgba(0, 255, 255, 0.3);
            border-top: 6px solid #0ef;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Fade In Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>
    <!-- Forgot Password Form -->
    <div class="container">
        <h1>Forgot Password</h1>
        <p>Enter your email to receive an OTP.</p>

        <!-- Success & Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('otp.send') }}" method="POST" onsubmit="submitForm()">
            @csrf
            <div class="input-group">
                <input type="email" id="email" name="email" placeholder=" " required oninput="toggleSendOtpButton()">
                <label for="email">Email Address</label>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn" id="sendOtpButton" disabled>Send OTP</button>
        </form>
    </div>

    <!-- Loading Screen -->
    <div id="loadingScreen" class="loading-overlay">
        <div class="loader"></div>
        <p style="margin-top: 10px;">Sending OTP, please wait...</p>
    </div>

    <script>
        function toggleSendOtpButton() {
            const emailInput = document.getElementById('email');
            const sendOtpButton = document.getElementById('sendOtpButton');

            // Enable button if email is valid
            sendOtpButton.disabled = !validateEmail(emailInput.value);
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple email regex
            return re.test(String(email).toLowerCase());
        }

        function showLoadingScreen() {
            document.getElementById('loadingScreen').style.display = 'flex'; // Show the loading screen
        }

        function disableSendOtpButton() {
            const sendOtpButton = document.getElementById('sendOtpButton');
            sendOtpButton.disabled = true; // Disable the button after submission
        }

        function submitForm() {
            showLoadingScreen(); // Show the loading screen
            disableSendOtpButton(); // Disable the button
        }
    </script>
</body>
</html>
