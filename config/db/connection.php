<?php
$conn = new MySQLi("localhost", "root", "local13@", "estoque", 3306);

$conn->connect_errno
  ? print "<script>alert('Erro ao conectar no banco de dados MySQL!')</script>"
  : null;
?>