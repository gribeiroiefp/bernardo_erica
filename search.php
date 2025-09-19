<?php
$conn = mysqli_connect('127.0.0.1', 'root','', 'livros_db');
if (!$conn) {
    die('Erro na ligação: ' . mysqli_connect_error());
}

$resultados_livros = [];

if (isset($_GET['string']) && !empty($_GET['string'])) {
    $string = $_GET['string'];
    $sql_livros = "SELECT * FROM livros WHERE titulo LIKE '%$string%'";
    $resultados_livros = mysqli_query($conn, $sql_livros);
}

$resultados_autores = [];

if (isset($_GET['string']) && !empty($_GET['string'])) {
    $string = $_GET['string'];
    $sql_autores = "SELECT * FROM autores WHERE nome LIKE '%$string%'";
    $resultados_autores = mysqli_query($conn, $sql_autores);
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
            <button class="col-2"><a href="addLivro.php"> Add Book </a></button>                   
            <button class="col-2"><a href="addAutor.php"> Add Author </a></button>
    </header>

<section class="box">
    <div class="container-lg search">
        <div class="pesquisa-form">
            <h2>Book Search</h2>
        </div>
        <div class="lista col">
            <form action="" method="GET">
                <div class="sombra-form">
                    <?php if (isset($_GET['string'])): ?>
                        <input type="text" name="string" placeholder="Search Book Title" required value="<?= $_GET['string'] ?>">
                    <?php else: ?>
                        <input type="text" name="string" placeholder="Search Book Title" required>
                    <?php endif; ?>
                    <button type="submit">Search</button>
                </div>
            </form>
        </div>
        <?php if (isset($_GET['string']) && !$_GET['string'] == ''): ?>
            <div class="lista col">
                <h3>Results</h3>
                <?php
                if ($resultados_livros && mysqli_num_rows($resultados_livros) > 0) {
                    while ($livro = mysqli_fetch_assoc($resultados_livros)) {
                        $id = $livro['id_livro'];
                        $capa = $livro['capa'];
                        $titulo = htmlspecialchars($livro['titulo']);
                        $ano = htmlspecialchars($livro['ano']);

                        echo <<<HTML
                    <a href="livro.php?id=$id" class="livro_link row align-items-end">
                        <img src="$capa" alt="$titulo" class="col-3">
                        <div class="livro col">
                            <h3>$titulo</h3>
                            <p>$ano</p>
                        </div>
                    </a>
                    HTML;
                    }
                }
                ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="container-lg search">
        <div class="pesquisa-form">
            <h2>Author Search</h2>
        </div>
        <div class="lista col">
            <form action="" method="GET">
                <div class="sombra-form">
                    <?php if (isset($_GET['string'])): ?>
                        <input type="text" name="string" placeholder="Search Author Name" required value="<?= $_GET['string'] ?>">
                    <?php else: ?>
                        <input type="text" name="string" placeholder="Search Author Name" required>
                    <?php endif; ?>
                    <button type="submit">Search</button>
                </div>
            </form>
        </div>
        <?php if (isset($_GET['string']) && !$_GET['string'] == ''): ?>
            <div class="lista col">
                <h3>Results</h3>
                <?php
                if ($resultados_autores && mysqli_num_rows($resultados_autores) > 0) {
                    while ($autor = mysqli_fetch_assoc($resultados_autores)) {
                        $id = $autor['id_autor'];
                        $foto = $autor['foto'];
                        $nome = htmlspecialchars($autor['nome']);

                        echo <<<HTML
                    <a href="autor.php?id=$id" class="autor_link row align-items-end">
                        <img src="$foto" alt="$nome" class="col-3">
                        <div class="autor col">
                            <h3>$nome</h3>
                        </div>
                    </a>
                    HTML;
                    }
                }
                ?>
            </div>
        <?php endif; ?>
    </div>
</section>

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