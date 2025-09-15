<?php
$conn = mysqli_connect('127.0.0.1', 'root', '', 'livros_db');
if (!$conn) {
    die('Erro na ligação: ' . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $ano = $_POST['ano'];
    $id_autor = $_POST['id_autor'];

    
    $dir = "uploads/capas/";
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    $capa = $dir . basename($_FILES["capa"]["name"]);
    move_uploaded_file($_FILES["capa"]["tmp_name"], $capa);

    // Inserir livros
    $sql = "INSERT INTO livros (titulo, ano, capa) VALUES ('$titulo', '$ano', '$capa')";
    if (mysqli_query($conn, $sql)) {
        $id_livro = mysqli_insert_id($conn);
        mysqli_query($conn, "INSERT INTO livro_autor (id_livro, id_autor) VALUES ($id_livro, $id_autor)");
        echo "<div class='alert alert-success text-center'>✅ Livro adicionado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Erro: " . mysqli_error($conn) . "</div>";
    }
}

// Procurar autores dropdown
$autores = mysqli_query($conn, "SELECT id_autor, nome FROM autores ORDER BY nome");


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
            <button class="col-2"> Add Author <a href="addAutor.php"></a></button>
        </nav>
    </header>

    <section class="box">
        <form action="addLivro.php" method="POST" enctype="multipart/form-data" class="mb-5 inserir">
            <input type="text" name="titulo" placeholder="Title" required class="form-control mb-3" />
            <input type="number" name="ano" placeholder="Publish Year" required min="1500" max="2099" step="1" class="form-control mb-3" />

            <label for="id_autor" class="form-label">Author:</label>
            <select name="id_autor" id="id_autor" required class="form-select mb-3">
                <option value="">-- Select Author --</option>
                <?php while ($a = mysqli_fetch_assoc($autores)): ?>
                    <option value="<?= $a['id_autor'] ?>"><?= htmlspecialchars($a['nome']) ?></option>
                <?php endwhile; ?>
            </select>

            <label for="capa" class="form-label">Book Cover (img):</label>
            <input type="file" name="capa" id="capa" accept="image/*" required class="form-control mb-3" />

            <button type="submit" class="btn btn-primary">Add Book</button>
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