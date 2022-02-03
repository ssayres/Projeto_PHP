<?php
//primeira tentativa
function listaPostagemDoUsuario($mysqli, $id){
 $postagens = [];
 $query = mysqli_query($mysqli, "SELECT * FROM usuarios where id=$id");
 while($postagem = mysqli_fetch_assoc($query)) {
   array_push($postagens, $postagem);
 }
 return $postagens;
}



?>