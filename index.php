<?php
$conn = mysqli_connect('127.0.0.1', 'root','', 'livros_db');
if (!$conn) {
    die('Erro na ligação: ' . mysqli_connect_error());
}

$sql_livros = "SELECT * FROM livros
 ORDER BY ano DESC LIMIT 3";
$resultado_livros = mysqli_query($conn, $sql_livros);

$sql_autores = "SELECT id_autor, nome, foto, ano_nascimento, nacionalidade, id_livro.livro_autor FROM autores
 JOIN livro_autor ON livros.id_livro = livro_autor.id_livro
 ORDER BY COUNT(id_livro.livro_autor) DESC LIMIT 3";
$resultado_autores = mysqli_query($conn, $sql_autores);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Bernardo e Erica">
    <title>Website de Livros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous" />
    <link rel="stylesheet" href="/css/styles.css" />
    <link rel="icon" type="image/png" href="/css/icon/book.png">
</head>

<body>

    <header class="container-fluid" style="background-color: #F29829" style="margin-bottom: 15px">
        <div class="container-lg">
            <div class="row align-items-center">
                <h1 class="col-4">Website de Livros</h1>
                <nav class="col text-end">
                    <a href="index.php" class="btn btn-danger">Homepage</a>
                </nav>
            </div>
        </div>
    </header>

    <div class="container-lg home">
        <h2>Filmes mais recentes</h2>
        <div class="row">
            <?php
            if ($resultado_livros && mysqli_num_rows($resultado_livros) > 0) {
                while ($row = mysqli_fetch_assoc($resultado_livros)) {
                    $id = $row['id_livro'];
                    $titulo = htmlspecialchars($row['titulo']);
                    $capa = htmlspecialchars($row['capa']);
                    echo <<<HTML
                    <div class="livro-recente-cont col">
                        <div class="livro-recente container" style="background-image: url('$capa');">
                            <a href="./livro.php?id=$id">
                                <div class="row align-items-end">
                                    <div class="col">
                                        <h3>$titulo</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    HTML;
                }
            }
            ?>
        </div>
    </div>
    <div class="container-lg home">
        <h2>Autores com mais Livros</h2>
        <div class="row">
            <?php
            if ($resultado_autores && mysqli_num_rows($resultado_autores) > 0) {
                while ($row = mysqli_fetch_assoc($resultado_autores)) {
                    $id = $row['id_autor'];
                    $nome = htmlspecialchars($row['nome']);
                    $foto = htmlspecialchars($row['foto']);
                    echo <<<HTML
                    <div class="autor-popular-cont col">
                        <div class="autor-popular container" style="background-image: url('$foto');">
                            <a href="./autor.php?id=$id">
                                <div class="row align-items-end">
                                    <div class="col">
                                        <h3>$nome</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    HTML;
                }
            }
            ?>
        </div>
    </div>
    <footer class="container-fluid text-center">
        <div class="container-lg">
            <p>&copy;Website de Livros bernardo_erica</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
    </body>
</html>