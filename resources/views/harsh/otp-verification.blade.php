<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('css/otp_verification.css') }}">
</head>

<body>
    <div class="container">
        <div class="form-wrapper">
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
                    <label for="otp">OTP</label>
                    <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
                    @error('otp')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="verify-btn" id="verifyBtn" disabled>Verify OTP</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            const otpInput = $('#otp');
            const verifyBtn = $('#verifyBtn');
            const otpForm = $('#otpForm');

            // Initialize Toastr options
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
            validateOTP();

            otpForm.on('submit', function(e) {
                const otpValue = otpInput.val().trim();
                if (!/^\d{6}$/.test(otpValue)) {
                    e.preventDefault();
                    toastr.error("Please enter a valid 6-digit OTP.");
                }
            });
        });
    </script>
</body>

</html>
