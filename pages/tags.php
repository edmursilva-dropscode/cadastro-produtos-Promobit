<div class="box-content-tag">
	
    <h2><i class="bi bi-tags-fill"></i> Adicionar Tags</h2>

	<form method="post" enctype="multipart/form-data"> <!--sem este atributo ENCTYPE, nao funciona o upload da imagem-->

        <!-- valida envio do formulario adicionar-tag -->          
		<?php

            //verifica se existe o metodo ACAO, para enviar o formulario adicionar  
			if(isset($_POST['acao'])){

                //variaveis de controle
				$descricao = $_POST['descricao'];

                //instancia a classe TAGS    
                $tagsProduto = new TagsProduto();

                //valida todos os campos do formulario  
				if($descricao == ''){
					Painel::alert('erro','A descricao está vázia!');
				}else{
					//valida se existe descricao da tag já cadastrado
					$verifica = MySql::conectar()->prepare("SELECT * FROM tb_site_tags WHERE descricao=?");
					$verifica->execute(array($descricao));
					if($verifica->rowCount() == 0){					
						//cadastrar a tag no bando de dados 
						if($tagsProduto->cadastrarTags($descricao)){
							Painel::alert('sucesso','O cadastro da tag foi feito com sucesso!');                        	
						}else{
							Painel::alert('erro','Erro ao cadastrar a tag!');
						}
					}else{
						Painel::alert('erro','Já existe uma tag com essa descrição!');
					}
				} 				
				echo "<meta HTTP-EQUIV='refresh' CONTENT='4'>";
			}
		?>

		<div class="form-group">
			<label>Descrição:</label>
			<input type="text" name="descricao">
		</div><!--form-group--> 

		<div class="form-group">
			<input type="submit" name="acao" value="Cadastrar">
		</div><!--form-group-->  

	</form>

</div><!--box-content-tag-->