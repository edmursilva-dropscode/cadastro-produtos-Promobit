<?php 
	if(isset($_GET['id'])){
		$id = (int)$_GET['id'];
		$categoria = CategoriasProduto::selecionarCategoria('tb_site_categorias','id = ?',array($id));
	}else{
		Painel::alert('erro','Você precisa passar o parametro ID.');
		die();
	}
 ?>
<div class="box-content-categoria">
	
    <h2><i class="bi bi-ui-checks"></i> Editar Categoria</h2>

	<form method="post" enctype="multipart/form-data"> <!--sem este atributo ENCTYPE, nao funciona o upload da imagem--> 

        <!-- valida envio do formulario adicionar-categoria -->       
		<?php

            //verifica se existe o metodo ACAO, para enviar o formulario adicionar 
			if(isset($_POST['acao'])){

                //variaveis de controle
				$descricao = $_POST['descricao'];			

				//echo '<script>alert("teste ")</script>';

                //instancia a classe CATEGORIA
                $categoriasProduto = new CategoriasProduto();

                //valida todos os campos do formulario 
				if($descricao == ''){
					Painel::alert('erro','A descrição está vázia!');
				}else{
					//valida se existe descricao da categoria já cadastrado
					$verifica = MySql::conectar()->prepare("SELECT * FROM tb_site_categorias WHERE descricao=? AND id != ?");
					$verifica->execute(array($descricao,$id));
					if($verifica->rowCount() == 0){					
						//alterar a categoria no bando de dados  
						if($categoriasProduto->alterarCategoria($id,$descricao)){
							Painel::alert('sucesso','Categoria foi alterada com sucesso!');   
							$categoria = CategoriasProduto::selecionarCategoria('tb_site_categorias','id = ?',array($id));                     	
						}else{
							Painel::alert('erro','Erro ao alterar a categoria!');
						}
					}else{
						Painel::alert('erro','Já existe uma categoria com essa descrição!');
						$categoria = CategoriasProduto::selecionarCategoria('tb_site_categorias','id = ?',array($id));   
					}						
				} 				
				echo "<meta HTTP-EQUIV='refresh' CONTENT='4'>";
			}
		?>

		<div class="form-group">
			<label>Descrição:</label>
			<input type="text" name="descricao" value="<?php echo $categoria['descricao']; ?>">
		</div><!--form-group-->   

		<div class="form-group">
			<input type="submit" name="acao" value="Atualizar">
            <input type="hidden" name="id" value="<?php echo $categoria['id']; ?>">
		</div><!--form-group-->  

	</form>

</div><!--box-content-categoria-->