<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="{{ asset('css/forgot_password.css') }}">

    <style>
        /* Loading Screen Styles */
        .loading-overlay {
            position: fixed; /* Fixed positioning to cover the entire viewport */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            display: flex; /* Use flexbox for centering */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            z-index: 1000; /* Ensure it's on top of everything */
            color: white; /* Text color */
            font-weight: bold; /* Make text thicker */
        }

        .loader {
            width: 60px; /* Width of the loader */
            height: 60px; /* Height of the loader */
            border-radius: 50%; /* Make it circular */
            background-color: #3498db; /* Color of the loader */
            animation: pulse 1.5s infinite; /* Pulsing animation */
        }

        @keyframes pulse {
            0% {
                transform: scale(1); /* Initial scale */
                opacity: 1; /* Full opacity */
            }
            50% {
                transform: scale(1.2); /* Scale up */
                opacity: 0.7; /* Slightly transparent */
            }
            100% {
                transform: scale(1); /* Scale back to original size */
                opacity: 1; /* Full opacity again */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h1>Forgot Password</h1>
            <p>Enter your email address to receive an OTP for resetting your password.</p>

            <!-- Success & Error Messages -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Step 1: Send OTP Form -->
            <form action="{{ route('otp.send') }}" method="POST" onsubmit="submitForm()">
                @csrf
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="your@email.com" required oninput="toggleSendOtpButton()">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn" id="sendOtpButton" disabled>Send OTP</button>
            </form>

            <hr>

            <div class="login-link"></div>
        </div>
    </div>

    <!-- Loading Screen -->
    <div id="loadingScreen" class="loading-overlay" style="display: none;">
        <div class="loader"></div>
        <p style="color:red;">Sending OTP, please wait...</p>
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
