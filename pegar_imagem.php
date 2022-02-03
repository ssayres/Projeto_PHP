
<?php
//teste de envio de imagem pelo usuario, atraves de um formulario
include("conexao.php");
$msg = false;
if($msg != false) echo "<p> $msg </p>";
if (isset($_FILES['foto'])) {
    
$codigo_antigo = $_POST['codigo_antigo'];
$imagem_antiga = $_POST['imagem_antiga'];
$extensao = strtolower(substr($_FILES['foto']['name'], -4));
$novo_nome = md5(time()) .$extensao;
$diretorio = "upload/";

move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$novo_nome);

$sql_code = "INSERT INTO usuarios(id, postagens, contagem_postagens) VALUES(null, '$novo_nome', NOW())";
$imagem=$novo_nome;

if($mysqli ->query($sql_code)) {
    //apagar a imagem antiga:
    //$sql_code = "DELETE FROM usuarios WHERE id=1 WHERE id != 1"; é viavel?
    $sql_code = "UPDATE usuarios SET id=1 WHERE id != 1";
    $mysqli ->query($sql_code);
    unlink("upload/$imagem_antiga");
    
    

    $msg = "Arquivo enviado com sucesso";
}
else 
    $msg = "Falha ao enviar o arquivo";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload foto</title>
</head>
<body>
<?php
 $resultado_foto = "SELECT id, postagens FROM usuarios ORDER BY id desc limit 1";
    $resultado_foto = mysqli_query($mysqli,$resultado_foto);
    $codigo_antigo = 0;
    while($rows_fotos = mysqli_fetch_array($resultado_foto)){
        $imagem = $rows_fotos['postagens'];
        $codigo_antigo = $rows_fotos['id'];
    }
    // array_map('unlink',glob("upload/$imagem"));é viavel?

   
    ?>
    <h1>Formulário teste</h1>
    <form action="pegar_imagem.php" method="POST" enctype="multipart/form-data">
    Arquivo: <input type="file" required name="foto"/>
    <input type="hidden" value="<?php print $codigo_antigo ; ?>" name="codigo_antigo"/>
    <input type="hidden" value="<?php print $imagem ; ?>" name="imagem_antiga"/>
    <br/>
	<input type="submit" value="Enviar"/>
    </form>
    <img src="upload/<?php echo $imagem ?>" class="media-object" height="250" width="250"/>
</body>
</html>

