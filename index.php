<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<form method="get">
<?php

  //conecta com o banco
  $conn = new PDO("mysql:host=localhost; dbname=estados-cidades-bairros", "root", "");

  //selecionas os estados
  $stmt = $conn->prepare("SELECT uf FROM estados ORDER BY uf");
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo "<div id='formulario'><select name='uf' id='uf'>";
  echo "<option value=''>-- Selecione --</option>";

    foreach($result as $row){
      foreach($row as $val){
          echo "<option value='$val'>$val";
          echo "</option>";
      }
    }

  echo "</select></div>";
 echo $_REQUEST['cidade'];
?>


<input type="submit" id="localizar-endereco-01" name="localizar-endereco-01" value="localizar">
</form>

<script type="text/javascript">

$(document).ready(function(){

  //Função Geral para buscar os itens no banco
  function buscar(qualTipoSelecionou, qualPegar, qualSelecionou, nomeDiv){

    $.ajax({
      type: "POST",  
      url: "localizacoes.php",
      data: ({qualTipoSelecionou: qualTipoSelecionou, qualPegar: qualPegar, qualSelecionou: qualSelecionou, nomeDiv: nomeDiv}),
      success: function($result){  
        $("#formulario").append($result);  
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) { 
      },

    });

  }

  //Função para buscar a Cidades
  $('body').on('change', '#uf', function(){
    qualSelecionou = $(this).val();
    $("#cidade").remove();
    $("#bairro").remove();
    buscar("flg_estado", "cidades", qualSelecionou,"cidade");
  });

 
  //Função para buscar a Bairros
  $('body').on('change', '#cidade', function(){
    qualSelecionou = $(this).val();
    $("#bairro").remove();
    buscar("cidade_id", "bairros", qualSelecionou,"bairro");
  });









  //Função para trocar os valores dos campos: Cidades e bairros
  $("#localizar-endereco-01").click(function(){
    $("#cidade option:selected" ).val($("#cidade option:selected" ).text());
  });


/*
  //Função para tirar acentos e espaços
  var slug = function(str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "ÁÄÂÀÃÅČÇĆĎÉĚËÈÊẼĔȆÍÌÎÏŇÑÓÖÒÔÕØŘŔŠŤÚŮÜÙÛÝŸŽáäâàãåčçćďéěëèêẽĕȇíìîïňñóöòôõøðřŕšťúůüùûýÿžþÞĐđßÆa·/_,:;";
    var to   = "AAAAAACCCDEEEEEEEEIIIINNOOOOOORRSTUUUUUYYZaaaaaacccdeeeeeeeeiiiinnooooooorrstuuuuuyyzbBDdBAa------";
    for (var i=0, l=from.length ; i<l ; i++) {
      str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
      .replace(/\s+/g, '-') // collapse whitespace and replace by -
      .replace(/-+/g, '-'); // collapse dashes

    str = str.toUpperCase();

    return str;
  };*/

});




</script>