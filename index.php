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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Author" content="Bernardo Silvestre e Erica Henrique">
    <!-- icon -->
    <link rel="icon" type="image/gif" href="./css/icon/arpa.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <!-- Link para Fontes externas -->
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Roboto+Slab:wght@100;200&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <title>Reader's Personal Archive</title>
</head>

<body>
    <header><br>
        <section class="container-fluid">
            <h1><b>R-PA</b></h1>
            <h3> Deciding what to read next? <br> Here is what you've read before! </h6>
            <h3> Your all in a website personal archive</h7>
        </section>
        <nav>
            <button class="col-2"> Novo Livro <a href="addlivro.php"></a></button>                   
            <button class="col-2"> Novo Autor <a href="addautor.php"></a></button>
        </nav>
    </header>
   <section class="box">
        <div class="container-lg">
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
                                            <h6>$titulo</h6>
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
        <div class="container-lg">
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
                                            <h6>$nome</h6>
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
    </section>
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