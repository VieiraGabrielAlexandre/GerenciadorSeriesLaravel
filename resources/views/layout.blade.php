<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous">
<title>Controle de Séries</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-2 d-flex justify-content-between">
        <a class="navbar navbar-expand-lg" href="{{ route('listar_series') }}">Home</a>
        @auth
            <a href="/sair" class="text-danger">Sair</a>
        @endauth
        @guest
            <a href="/sair" class="text-success">Entrar</a>
        @endguest

    </nav>
    <div class="container">
        <div class="jumbotron h1">
            <div class="h1">@yield('cabecalho')</div>
        </div>

        @yield('conteudo')

    </div>

</body>
</html>
