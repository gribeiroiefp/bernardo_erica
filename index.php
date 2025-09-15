<?php
$conn = mysqli_connect('127.0.0.1', 'root','', 'livros_db');
if (!$conn) {
    die('Erro na ligação: ' . mysqli_connect_error());
}

$sql_livros = "SELECT id_livro, titulo, capa FROM livros
ORDER BY ano DESC LIMIT 3";
$resultado_livros = mysqli_query($conn, $sql_livros);

$sql_autores = "SELECT autores.id_autor, autores.nome, autores.foto, autores.ano_nascimento, autores.nacionalidade, 
COUNT(livro_autor.id_livro) AS total_livros FROM autores
JOIN livro_autor ON autores.id_autor = livro_autor.id_autor
JOIN livros ON livros.id_livro = livro_autor.id_livro
GROUP BY autores.id_autor, autores.nome, autores.foto, autores.ano_nascimento, autores.nacionalidade
ORDER BY total_livros DESC LIMIT 3;";
$resultado_autores = mysqli_query($conn, $sql_autores);

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
            <button class="col-2" style=" width: 5px; background-color: #401201;"><a href="index.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
</svg></a></button>
            <button class="col-2"> Search <a href="search.php"></a></button>
            <button class="col-2"> Add Book <a href="addLivro.php"></a></button>                   
            <button class="col-2"> Add Author <a href="addAutor.php"></a></button>
        </nav>
    </header>


   <section class="container-lg box">
        <div class="container-lg homepage">
            <h2>New Releases</h2>
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
                                        <h2>$titulo</h2>
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
        <div class="container-lg homepage">
            <h2>By Bibliography Size</h2>
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
                                            <h2>$nome</h2>
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