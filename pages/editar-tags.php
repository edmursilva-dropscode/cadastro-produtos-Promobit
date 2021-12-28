<?php 
	if(isset($_GET['id'])){
		$id = (int)$_GET['id'];
		$tag = TagsProduto::selecionarTag('tb_site_tags','id = ?',array($id));
	}else{
		Painel::alert('erro','Você precisa passar o parametro ID.');
		die();
	}
 ?>
<div class="box-content-tag">
	
    <h2><i class="bi bi-tags-fill"></i> Editar Tag</h2>

	<form method="post" enctype="multipart/form-data"> <!--sem este atributo ENCTYPE, nao funciona o upload da imagem-->

        <!-- valida envio do formulario adicionar-tag -->         
		<?php

            //verifica se existe o metodo ACAO, para enviar o formulario adicionar 
			if(isset($_POST['acao'])){

                //variaveis de controle
				$descricao = $_POST['descricao'];			

				//echo '<script>alert("teste ")</script>';

                //instancia a classe TAGS
                $tagsProduto = new TagsProduto();

                //valida todos os campos do formulario 
				if($descricao == ''){
					Painel::alert('erro','A descrição está vázia!');
				}else{
					//valida se existe descricao da tag já cadastrado
					$verifica = MySql::conectar()->prepare("SELECT * FROM tb_site_tags WHERE descricao=? AND id != ?");
					$verifica->execute(array($descricao,$id));
					if($verifica->rowCount() == 0){					
						//alterar a tag no bando de dados  
						if($tagsProduto->alterarTag($id,$descricao)){
							Painel::alert('sucesso','Tag foi alterada com sucesso!');   
							$tag = TagsProduto::selecionarTag('tb_site_tags','id = ?',array($id));                     	
						}else{
							Painel::alert('erro','Erro ao alterar a tag!');
						}
					}else{
						Painel::alert('erro','Já existe uma tag com essa descrição!');
						$tag = TagsProduto::selecionarTag('tb_site_tags','id = ?',array($id));   
					}						                    
				} 	
				echo "<meta HTTP-EQUIV='refresh' CONTENT='4'>";			
			}
		?>

		<div class="form-group">
			<label>Descrição:</label> 
			<input type="text" name="descricao" value="<?php echo $tag['descricao']; ?>">
		</div><!--form-group-->   

		<div class="form-group">
			<input type="submit" name="acao" value="Atualizar">
            <input type="hidden" name="id" value="<?php echo $tag['id']; ?>">
		</div><!--form-group-->  

	</form>

</div><!--box-content-tag-->