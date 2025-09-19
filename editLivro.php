<?php
$conn = mysqli_connect('127.0.0.1', 'root', '', 'livros_db');
if (!$conn) {
    die('Erro na ligação: ' . mysqli_connect_error());
}

if (!isset($_GET['id'])) {
    die("⚠️ Nenhum livro selecionado.");
}
$id_livro = intval($_GET['id']);

// procurar dados do livro
$result = mysqli_query($conn, "SELECT * FROM livros WHERE id_livro = $id_livro");
$livro = mysqli_fetch_assoc($result);
if (!$livro) {
    die("⚠️ Livro não encontrado.");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $ano = $_POST['ano'];
    $capa = $livro['capa']; // capa atual

    // Se o utilizador carregar uma nova imagem
    if (!empty($_FILES["capa"]["name"])) {
        $dir = "uploads/capas/";
        if (!is_dir($dir)) mkdir($dir, 0777, true);
        $capa = $dir . basename($_FILES["capa"]["name"]);
        move_uploaded_file($_FILES["capa"]["tmp_name"], $capa);
    }

    // Atualizar livro
    $sql = "UPDATE livros SET titulo='$titulo', ano='$ano', capa='$capa' WHERE id_livro=$id_livro";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success text-center'>✅ Livro atualizado com sucesso!</div>";
        $livro['titulo'] = $titulo;
        $livro['ano'] = $ano;
        $livro['capa'] = $capa;
    } else {
        echo "<div class='alert alert-danger text-center'>Erro: " . mysqli_error($conn) . "</div>";
    }
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
        </nav>
    </header>

    <section class="box">
        <h2>Edit Book</h2>
    <?php if ($mensagem): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($mensagem) ?></div>
    <?php endif ?>
    <form action="editLivro.php?id=<?php echo htmlspecialchars($livro['id']) ?>" 
          method="POST" enctype="multipart/form-data" class="mb-5 inserir">
        <input type="text" name="titulo" placeholder="Título" required class="form-control mb-3"
               value="<?php echo htmlspecialchars($livro['titulo']) ?>" />
        <input type="number" name="ano" placeholder="Ano" required min="1888" max="2099" step="1" 
               class="form-control mb-3" value="<?php echo htmlspecialchars($livro['ano']) ?>" />
        <input type="text" name="diretor" placeholder="Diretor" required class="form-control mb-3" 
               value="<?php echo htmlspecialchars($livro['diretor']) ?>" />
        <label for="capa" class="form-label">Book Cover (imag):</label>
        <input type="file" name="capa" id="capa" accept="image/*" class="form-control mb-3" />
        <?php if (!empty($livro['capa'])): ?>
            <img src="<?php echo htmlspecialchars($livro['capa']) ?>" alt="book cover" class="foto">
        <?php endif ?>
        <button type="submit" class="btn btn-primary">Edit</button>
    </form>
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