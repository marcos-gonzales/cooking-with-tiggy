<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8"/>
</head>
<body>
<h2>Oh no you forgot your password</h2>
<p>Its okay were here to help.</p>
<input type="hidden" value="{{$test_email}}" name="email"/>
<a href="http://localhost:8000/forgot-password/{{$test_message}}">reset password</a>
</body>
</html>
