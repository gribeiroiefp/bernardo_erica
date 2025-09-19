<?php
$conn = mysqli_connect('127.0.0.1', 'root', '', 'livros_db');
if (!$conn) {
    die('Erro na ligação: ' . mysqli_connect_error());
}

// Obter o ID do autor
if (!isset($_GET['id'])) {
    die("⚠️ Nenhum autor selecionado.");
}
$id_autor = intval($_GET['id']);

// Buscar os dados do autor
$result = mysqli_query($conn, "SELECT * FROM autores WHERE id_autor = $id_autor");
$autor = mysqli_fetch_assoc($result);
if (!$autor) {
    die("⚠️ Autor não encontrado.");
}

// Atualizar caso o formulário seja submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $ano_nascimento = $_POST['ano_nascimento'];
    $nacionalidade = $_POST['nacionalidade'];
    $foto = $autor['foto']; // mantém foto atual

    // Se carregar nova imagem
    if (!empty($_FILES["foto"]["name"])) {
        $dir = "uploads/fotos/";
        if (!is_dir($dir)) mkdir($dir, 0777, true);
        $foto = $dir . basename($_FILES["foto"]["name"]);
        move_uploaded_file($_FILES["foto"]["tmp_name"], $foto);
    }

    // Atualizar dados
    $sql = "UPDATE autores 
            SET nome='$nome', ano_nascimento='$ano_nascimento', nacionalidade='$nacionalidade', foto='$foto' 
            WHERE id_autor=$id_autor";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success text-center'>✅ Autor atualizado com sucesso!</div>";
        $autor['nome'] = $nome;
        $autor['ano_nascimento'] = $ano_nascimento;
        $autor['nacionalidade'] = $nacionalidade;
        $autor['foto'] = $foto;
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
         <h2>Edit Author</h2>
        <?php if ($mensagem): ?> <div class="alert alert-info"><?php echo htmlspecialchars($mensagem) ?></div> <?php endif ?>
        <form action="editAutor.php?id=<?php echo htmlspecialchars($autor['id']) ?>" method="POST" enctype="multipart/form-data" class="mb-5 inserir">
            <input type="text" name="nome" placeholder="Nome" required class="form-control mb-3" value="<?php echo htmlspecialchars($autor['nome']) ?>" />
            <input type="year" name="ano_nascimento" required class="form-control mb-3" value="<?php echo htmlspecialchars($autor['ano_nascimento']) ?>" />
            <input type="text" name="nacionalidade" placeholder="Nacionalidade" required class="form-control mb-3" value="<?php echo htmlspecialchars($autor['nacionalidade']) ?>" />
            <label for="foto" class="form-label">Author (imag):</label>
            <input type="file" name="foto" id="foto" accept="image/*" class="form-control mb-3" />
             <?php if (!empty($autor['foto'])): ?> <img src="<?php echo htmlspecialchars($autor['foto']) ?>" alt="Author's picture" class="foto">
                <?php endif ?> <button type="submit" class="btn btn-primary">Edit</button>
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