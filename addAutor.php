<?php
$conn = mysqli_connect('127.0.0.1', 'root','', 'livros_db');
if (!$conn) {
    die('Erro na ligação: ' . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $ano = $_POST['ano_nascimento'];
    $nacionalidade = isset($_POST['nacionalidade']) ? trim($_POST['nacionalidade']) : "";

    // Verificar se já existe o autor
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM autores WHERE nome = ? AND ano_nascimento = ? AND nacionalidade = ?");
    $checkStmt->bind_param("sss", $nome, $ano_nascimento, $nacionalidade);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        echo "<div class='alert alert-warning text-center'>⚠️ Autor já existe na base de dados!</div>";
    } else {
        
        $targetDir = "uploads/fotos/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = basename($_FILES["foto"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFilePath)) {
                $stmt = $conn->prepare("INSERT INTO autores (nome, ano_nascimento, nacionalidade, foto) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $nome, $ano_nascimento, $nacionalidade, $targetFilePath);

                if ($stmt->execute()) {
                    echo "<div class='alert alert-success text-center'>✅ Autor adicionado com sucesso!</div>";
                } else {
                    echo "<div class='alert alert-danger text-center'>Erro: " . $stmt->error . "</div>";
                }

                $stmt->close();
            } else {
                echo "<div class='alert alert-warning text-center'>Erro ao fazer upload da foto.</div>";
            }
        } else {
            echo "<div class='alert alert-warning text-center'>O ficheiro não é uma imagem válida.</div>";
        }
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
            <button class="col-2"> Home <a href="index.php"></a></button>
            <button class="col-2"> Search <a href="search.php"></a></button>
            <button class="col-2"> Add Book <a href="addLivro.php"></a></button>                   
            <button class="col-2"> Add Author <a href="addAutor.php"></a></button>
        </nav>
    </header>

    <section class="box">
        <h2>New Author</h2>
        <?php if ($msg): ?>
            <div class="alert alert-info"><?= $msg ?></div>
        <?php endif; ?>
        <form action="addAutor.php" method="POST" enctype="multipart/form-data" class="mb-5 inserir">
            <input type="text" name="nome" placeholder="Name" required class="form-control mb-3" />
            <input type="number" name="ano_nascimento" placeholder="Birthyear" required min="1500" max="2099" step="1" class="form-control mb-3" />
            <input type="text" name="nacionalidade" placeholder="Nationality" required class="form-control mb-3" />
            <label for="foto" class="form-label">Author Photo (img):</label>
            <input type="file" name="foto" id="foto" accept="image/*" required class="form-control mb-3" />
            <button type="submit" class="btn btn-primary">Add Author</button>
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