<?php
$conn = mysqli_connect('127.0.0.1', 'root','', 'livros_db');
if (!$conn) {
    die('Erro na ligação: ' . mysqli_connect_error());
}

$id = (int) $_GET['id'];

$sql_autor = "SELECT * FROM autores WHERE id_autor = $id";
$resultado = mysqli_query($conn, $sql);
$livro = mysqli_fetch_assoc($resultado);

$sql_livros = "SELECT livros.id_livro, livros.titulo, livros.ano, livros.capa
               FROM livros
               JOIN livro_autor ON livros.id_livro= livro_autor.id_livro
               WHERE livro_autor.id_autor = $id";
$resultado_atores = mysqli_query($conn, $sql_autores);

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
        <section class="container-fluid">
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
            <button class="col-2"> Add Book <a href="addLivro.html"></a></button>                   
            <button class="col-2"> Add Author <a href="addAutor.html"></a></button>
        </nav>
    </header>

    <section class="box">
         <div class="row align-items-center">
            <h2><?php echo htmlspecialchars($autor['nome']) ?></h2>
            <img src="<?php echo htmlspecialchars($autor['foto']) ?>"
                alt="$nome" class="col-3">
            <div class="informacao col-8">
                <p><span class="rotulo ano">Birth Year:</span> <?php echo htmlspecialchars($autor['ano_nascimento']) ?></p>
                <p><span class="rotulo genero">Nacionality:</span> <?php echo htmlspecialchars($autor['nacionalidade']) ?></p>
            </div>
            <div class="col-1 opcoes align-self-start">
                <a href="editAutor.php?id=<?php echo htmlspecialchars($ator['id']) ?>" class="btn btn-primary btn-editar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                    </svg></a>
                <form method="POST" onsubmit="return confirm('Are you sure you wish to delete this author?')">
                    <button type="submit" class="btn btn-danger btn-remover"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                        </svg></button>
                </form>
            </div>
        </div>
        <div class="lista col">
            <h3>Works</h3>
            <?php
            if ($resultado_livros && mysqli_num_rows($resultado_livros) > 0)
                while ($livro = mysqli_fetch_assoc($resultado_livros)) {
                    $id_livro = $livro['id'];
                    $capa = $livro['capa'];
                    $titulo = htmlspecialchars($livro['titulo']);
                    $ano = htmlspecialchars($livro['ano']);
                    echo <<<HTML
                    <a href="livro.php?id=$id_livro" class="row align-items-end">
                        <img src="$capa" alt="$titulo" class="col-2">
                        <div class="livro col-10">
                            <h3>$titulo</h3>
                            <p>$ano</p>
                        </div>
                    </a>
                    HTML;
                }
            ?>
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