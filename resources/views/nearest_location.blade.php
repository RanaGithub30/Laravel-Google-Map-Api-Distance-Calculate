<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nearest Users</title>
</head>
<body>

<strong>People Near me are: </strong><br>
    @foreach($user_details as $data)
          {{$data->name}} <br>
    @endforeach
</body>
</html>