<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
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