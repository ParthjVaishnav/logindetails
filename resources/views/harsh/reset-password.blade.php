<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            box-sizing: border-box;
        }

        .form-wrapper {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 26px;
            animation: slideInDown 0.7s ease-out;
        }

        @keyframes slideInDown {
            from { transform: translateY(-100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            outline: none;
        }

        input[type="password"]::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .reset-btn {
            background: #ff7eb3;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }

        .reset-btn:hover {
            background: #ff5f99;
        }

        .reset-btn:disabled {
            background: rgba(255, 255, 255, 0.3);
            cursor: not-allowed;
        }

        .alert {
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.8);
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.8);
        }

        .text-danger {
            color: #ff4d4d;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-wrapper">
            <h1>Reset Password</h1>
            <p>Enter your new password</p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('password.reset') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter new password" required oninput="validateInputs()">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required oninput="validateInputs()">
                </div>
                <button type="submit" class="reset-btn" id="resetPasswordButton" disabled>Reset Password</button>
            </form>
        </div>
    </div>

    <script>
        function validateInputs() {
            let password = document.getElementById('password').value;
            let confirmPassword = document.getElementById('password_confirmation').value;
            let resetButton = document.getElementById('resetPasswordButton');
            resetButton.disabled = !(password.length > 0 && confirmPassword.length > 0);
        }
    </script>
</body>

</html>
