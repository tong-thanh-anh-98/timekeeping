<!DOCTYPE html>
<html>
<head>
    <title>Your New Account</title>
</head>
<body>
    <h1>Welcome, {{ $name }}!</h1>
    <p>You have been registered on our platform. Here are your login credentials:</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>Please log in and change your password as soon as possible.</p>
    <p>Thank you!</p>
</body>
</html>