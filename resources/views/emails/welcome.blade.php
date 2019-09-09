<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>

<body>
<h2>Welcome to our system {{$user['first_name']}} {{$user['last_name']}}</h2>
<br/>
Your registered email is {{$user['email']}}
</body>

</html>