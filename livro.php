<?php
$conn = mysqli_connect('127.0.0.1', 'root','', 'livros_db');
if (!$conn) {
    die('Erro na ligação: ' . mysqli_connect_error());
}

$id = (int) $_GET['id'];

$sql_livro = "SELECT * FROM livros WHERE id_livro = $id";
$resultado = mysqli_query($conn, $sql);
$livro = mysqli_fetch_assoc($resultado);

$sql_autores = "SELECT autores.id_autor, autores.nome, autores.foto
               FROM autores 
               JOIN livro_autor ON autores.id_autor = livro_autor.id_autor
               WHERE livro_autor.id_livro = $id";
$resultado_atores = mysqli_query($conn, $sql_autores);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="Author" content="Bernardo e Erica">
        <link rel="icon" type="image/gif" href="/css/icon/book.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Roboto+Slab:wght@100;200&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/css/styles.css">
        <title>Website de Livros</title>
    </head>

    <body>
        <header class="container-fluid" style="background-color: #00481d">
            <nav class="nav">
                <div class="container">
                <div class="row align-items-center">
                    <h1> Website de Livros</h1>
                    <nav class="col text-end">
                        <a href="index.php" class="btn btn-warning"> Homepage </a>
                        <a href="livro.php" class="btn btn-warning"> Livros </a>
                        <a href="autor.php" class="btn btn-warning"> Autor </a>
                    </nav>
                </div>
                </div>
            </nav>
        </header>

        <div class="row align-items-start info">
            <img src="<?php echo htmlspecialchars($livro['capa']); ?>" alt="$titulo" class="col-3">
            <div class="col-8">
                <h2><?php echo htmlspecialchars($livro['titulo']); ?></h2>
                <p><span class="rotulo ano">Ano:</span> <?php echo htmlspecialchars($livro['ano']); ?></p>
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