<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1><br>
    <h4>{{auth()->user()->name}}</h4>
    <h4>{{auth()->user()->email}}</h4>
    <form action="{{route('auth.login.destroy')}}" method="post">
        @csrf
        <button type="submit">Sair</button>
    </form>
</body>
</html>
