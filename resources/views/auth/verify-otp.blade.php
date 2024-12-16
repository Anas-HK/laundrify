<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .verify-otp-container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            color: #555;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            outline: none;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        input[type="text"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-top: -15px;
            margin-bottom: 20px;
        }
    </style>

</html>
</head>
<body>
<form action="{{ route('verify.otp') }}" method="POST">
    @csrf
    <label for="otp">Enter OTP:</label>
    <input type="text" id="otp" name="otp" required>
    @if($errors->has('otp'))
        <div style="color: red;">{{ $errors->first('otp') }}</div>
    @endif
    <button type="submit">Verify</button>
</form>

</body>
</html>