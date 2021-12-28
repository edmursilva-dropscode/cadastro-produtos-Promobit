<div class="box-content-categoria">
	
    <h2><i class="bi bi-ui-checks"></i> Adicionar Categorias</h2>

	<form method="post" enctype="multipart/form-data"> <!--sem este atributo ENCTYPE, nao funciona o upload da imagem-->

        <!-- valida envio do formulario adicionar-categoria -->         
		<?php

            //verifica se existe o metodo ACAO, para enviar o formulario adicionar   
			if(isset($_POST['acao'])){

                //variaveis de controle
				$descricao = $_POST['descricao'];

                //instancia a classe CATEGORIA    
                $categoriasProduto = new CategoriasProduto();

                //valida todos os campos do formulario
				if($descricao == ''){
					Painel::alert('erro','A descricao está vázia!');
				}else{
					//valida se existe descricao de categoria já cadastrado
					$verifica = MySql::conectar()->prepare("SELECT * FROM tb_site_categorias WHERE descricao=?");
					$verifica->execute(array($descricao));
					if($verifica->rowCount() == 0){					
						//cadastrar a categoria no bando de dados 
						if($categoriasProduto->cadastrarCategorias($descricao)){
							Painel::alert('sucesso','O cadastro da categoria foi feito com sucesso!');                        	
						}else{
							Painel::alert('erro','Erro ao cadastrar a categoria!');
						}
					}else{
						Painel::alert('erro','Já existe uma categoria com essa descrição!');
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

</div><!--box-content-categoria-->