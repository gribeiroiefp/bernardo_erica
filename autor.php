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