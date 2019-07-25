<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>To confirm the email, please follow the link.</h1>
    <a href="{{ route('confirm-email', [$user, $token]) }}">Press here</a>
</body>
</html>