<?php
$conn = mysqli_connect('127.0.0.1', 'root','', 'livros_db');
if (!$conn) {
    die('Erro na ligação: ' . mysqli_connect_error());
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Author" content="Bernardo Silvestre e Erica Henrique">
    <link rel="icon" type="image/gif" href="./css/icon/arpa.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Roboto+Slab:wght@100;200&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <title>Reader's Personal Archive</title>
</head>

<body style="background-image: url(./css/img/bookvector.jpg);">

    <header><br>
        <section class="container-fluid headbox">
            <table>
                <tr>
                    <td class="name col-1" rowspan="3"><img src="./css/img/logo.png" alt="logo R-Pa"></td>
                    <td class="tagline">Deciding what to read next? </td>
                </tr>
                <tr>
                    <td class="tagline">Here is what you've read before! </td>
                </tr>
                <tr>
                    <td class="tagline">Your all in a website personal archive</td>
                </tr>
                
            </table>
        </section>
        <nav>
            <button class="col-2"><a href="index.php"> Home </a></button>
            <button class="col-2"><a href="search.php"> Search </a></button>
            <button class="col-2"><a href="addLivro.php"> Add Book </a></button>                   
            <button class="col-2"><a href="addAutor.php"> Add Author </a></button>
    </header>

    <div class="container-lg search">
        <div class="pesquisa-form">
            <h2>Book Search</h2>
            <form action="">
                <div class="sombra-form">
                    <input type="text" name="texto" placeholder="Search Title" required>
                    <button type="submit">Search</button>
                </div>
            </form>
        </div>
        <div class="lista col">
            <h3>Results</h3>
            <a href="livro.html" class="livro_link row align-items-end">
                <img src="capa" alt="$titulo" class="col-3">
                <div class="livro col">
                    <h3>titulo</h3>
                    <p>ano</p>
                </div>
            </a>
        </div>
    </div>

    <footer class="container-fluid text-center">
        <div class="container-lg">
            <p>&copy;Website de Livros bernardo_erica</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous">
    </script>

    </body>
</html>