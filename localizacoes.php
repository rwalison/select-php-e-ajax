<?php

  //seleciona a cidades
  $conn = new PDO("mysql:host=localhost; dbname=estados-cidades-bairros", "root", "");

  $where = $_POST['qualTipoSelecionou'];
  $whereItem = $_POST['qualSelecionou'];
  $tabela = $_POST['qualPegar'];
  $nomeDiv = $_POST['nomeDiv'];


  $stmt = $conn->prepare("SELECT desc_local, local_id FROM $tabela WHERE $where = '$whereItem' ORDER BY desc_local");
  $stmt->execute();
  $result = $stmt->fetchALL(PDO::FETCH_ASSOC);

  echo "<select name='".$nomeDiv."' id='".$nomeDiv."'>";
  echo "<option value=''>-- Selecione --</option>";

    foreach($result as $row){
        echo "<option value='".$row['local_id']."'>".$row['desc_local'];
        echo "</option>";
    }

  echo "</select>";


?>
