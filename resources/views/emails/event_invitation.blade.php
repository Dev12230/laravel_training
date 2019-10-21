<!DOCTYPE html>
<html>
<head>
    <title>Invitation Email</title>
</head>
<h1>Join us</h1>
<h3>{{$event['main_title']}}</h3>
<h4>{{$event['secondary_title']}}</h4>
<body>

<p>from: {{$event['start_date']}}</p>
<p>to: {{$event['end_date']}}</p>
@if(isset($event['address_address']))
<p>at: {{$event['address_address']}}</p>
@endif
<br/>
</body>
</html>