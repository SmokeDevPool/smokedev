<?php
include 'actions/connection.php';
session_start();
if(isset($_SESSION['logado']) AND isset($_SESSION['cliente']) AND isset($_GET['plugin']) AND isset($_GET['id'])):
    $sql = "SELECT * FROM plugins WHERE usuario = '".$_SESSION['cliente']."' AND id = ".$_GET['id']." AND plugin = '".$_GET['plugin']."'";
    $consult = mysqli_query($connectar, $sql);
    $resultado = mysqli_fetch_assoc($consult);
    if($resultado):
    //se verdadeiro
    ?>
    <!-- codigo html para formulario -->
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <!--Let browser know website is optimized for mobile-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script src="jquery-3.2.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Editar <?php echo $resultado['plugin'];?> </title>
    </head>
    <body>
        <div class="container row">
             <h4>Alterar ip do <?php echo $resultado['plugin'];?></h4>
            <div class="col s12 m12 l12">
                <form action="index.php?action=editado&id=<?php echo $_GET['id']?>" method="POST">
                    
                    <input type="text" placeholder="ip atual é <?php echo $resultado['serverip'];?>" title="formato exemplo: 257.412.02.33" pattern="[0-9]{3}.[0-9]{3}.[0-9]{1,3}.[0-9]{1,3}" id="ip" name="ip">                   
                    <button class="btn green" name="btn-alterar">Alterar</button>
                    <a href="index.php" class="btn red">Cancelar</a>
                </form>
            </div>
        </div>
    </body>
    </html>
    <?php
    else:
        header("Location: index.php");
    endif;
else:
    header("Location: index.php");
endif;
?>