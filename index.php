<?php
$conn = mysqli_connect('127.0.0.1', 'root', '', 'livros_db');
if (!$conn) {
    die('Erro na ligação: ' . mysqli_connect_error());
}

$sql_livros = 'SELECT titulo, capa FROM livros
 ORDER BY ano DESC LIMIT 3';
$resultado = mysqli_query($conn, $sql_livros);

$sql_autores = ;
$resultado = mysqli_query($conn, $sql_autores);


?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Website de Livros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/styles.css" />
    </head>
    <body>
        
        <h1>Website de livros</h1>
    </body>
</html>