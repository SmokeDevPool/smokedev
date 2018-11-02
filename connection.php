<?php
$db_server = "localhost";
$db_user = "root";
$db_password = "";
$db_database = "vendas";
$connectar = mysqli_connect($db_server, $db_user, $db_password, $db_database);
mysqli_set_charset($connectar, "utf8");
if(mysqli_connect_error()){
    echo "Erro no banco de dados Firebird :3";
    exit;
}

?>