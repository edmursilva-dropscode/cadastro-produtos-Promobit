<?php 
	if(isset($_GET['id'])){
		$id = (int)$_GET['id'];
		$produtosPedido = ProdutosPedido::selecionarProduto('tb_site_produtos','id = ?',array($id));
	}else{
		Painel::alert('erro','Você precisa passar o parametro ID.');
		die();
	}
 ?>
<div class="box-content-produto">
	
    <h2><i class="bi bi-inboxes-fill"></i> Editar Produto</h2>

	<form method="post" enctype="multipart/form-data"> <!--sem este atributo ENCTYPE, nao funciona o upload da imagem-->

        <!-- valida envio do formulario adicionar-produto -->        
		<?php

            //verifica se existe o metodo ACAO, para enviar o formulario adicionar 
			if(isset($_POST['acao'])){

                //variaveis de controle
				$descricao = $_POST['descricao'];
				$id_categoria = $_POST['id_categoria'];
				$imagemAtualizada = $_FILES['imagemAtualizada'];				
				$imagemProduto = $_POST['imagemProduto'];	
				$preco = $_POST['preco'];		
				$numeroTotalProdutos = $produtosPedido['order_id'];

				//echo '<script>alert("teste ")</script>';

                //instancia a classe PRODUTO   
                $produtosPedido = new ProdutosPedido();

                //valida todos os campos do formulario
				if($descricao == ''){
					Painel::alert('erro','A descrição está vázio!');
                }else if($id_categoria == ''){
					Painel::alert('erro','A categoria está vázia!');
                }else if($preco == ''){
					Painel::alert('erro','O preço está vázio!');					
				}else{
					if($imagemAtualizada['name'] != ''){	

						//valida campos chaves do formulario  
						if(ProdutosPedido::imagemValida($imagemAtualizada) == false){
							Painel::alert('erro','O formato especificado não está correto!');
						}else{
							//valida se existe descricao de produto já cadastrado
							$verifica = MySql::conectar()->prepare("SELECT * FROM tb_site_produtos WHERE descricao=? AND id != ?");
							$verifica->execute(array($descricao,$id));
							if($verifica->rowCount() == 0){
								//Valida se existe a foto antiga e exclui
								if(ProdutosPedido::deletarFotoProduto($imagemProduto)){
									//alterar o produto no bando de dados  
									$imagemAtualizada = ProdutosPedido::uploadFile($imagemAtualizada);
									if($produtosPedido->alterarProdutos($id,$descricao,$id_categoria,$imagemAtualizada,$preco)){
										Painel::alert('sucesso','Produto foi alterado com sucesso!');                        	
										$produtosPedido = ProdutosPedido::selecionarProduto('tb_site_produtos','id = ?',array($id));                     	
									}else{
										Painel::alert('erro','Erro ao alterar o produto!');
									}
								}else{
									Painel::alert('erro','Erro ao alterar o produto!');
								}
							}else{
								Painel::alert('erro','Já existe um produto com essa descrição!');
								$produtosPedido = ProdutosPedido::selecionarProduto('tb_site_produtos','id = ?',array($id));  
							}								
						}						
					}else{
						//valida se existe descricao de produto já cadastrado  
						$verifica = MySql::conectar()->prepare("SELECT * FROM tb_site_produtos WHERE descricao=? AND id_categoria = ? AND id != ?");
						$verifica->execute(array($descricao,$id_categoria,$id));
						if($verifica->rowCount() == 0){						
							//alterar o produto no bando de dados   
							if($produtosPedido->alterarProdutos($id,$descricao,$id_categoria,$imagemProduto,$preco)){
								Painel::alert('sucesso','Produto foi alterado com sucesso!');   
								$produtosPedido = ProdutosPedido::selecionarProduto('tb_site_produtos','id = ?',array($id));                     	
							}else{
								Painel::alert('erro','Erro ao alterar o produto!');
							}
						}else{
							Painel::alert('erro','Já existe um produto com essa descrição!');
							$produtosPedido = ProdutosPedido::selecionarProduto('tb_site_produtos','id = ?',array($id));  
						}	
					}
				} 				
				echo "<meta HTTP-EQUIV='refresh' CONTENT='4'>";				
			}
		?>

		<div class="form-group">
            <label>Categoria:</label>
            <select name="id_categoria">
				<option value="">Seleciona um item</option>
                <?php
                    $categorias = Painel::selectAll('tb_site_categorias');
                    foreach ($categorias as $key => $value) {
                ?>
                <option <?php if($value['id'] == $produtosPedido['id_categoria']) echo 'selected'; ?> value="<?php echo $value['id'] ?>"><?php echo $value['descricao']; ?></option>
                <?php } ?>
            </select>
		</div>

		<div class="form-group">
			<label>Descrição:</label>
			<input type="text" name="descricao" value="<?php echo $produtosPedido['descricao']; ?>">
		</div><!--form-group-->   

		<div class="form-group">
			<label>Preço:</label>
			<input type="text" data-mask="000.000,00" name="preco" value="<?php echo $produtosPedido['preco']; ?>">
		</div><!--form-group--> 		

		<div class="form-group"> 

			<div class="row">
				
				<div class="box-produto0">

					<div class="box-produto1">
						
						<div class="imagem-produto">
							<i class="bi bi-image-fill"></i><!--avatar-produto-->    
							<img src="<?php echo INCLUDE_PATH_PAINEL ?>/uploads/produtos/<?php echo $produtosPedido['img']; ?>" id="imagem-upload-produto" alt><!--imagem-produto-->
						</div>
							
						<label>Imagem</label>
					</div> 				
					
                    <div class="box-produto2">
					    <input type="file" name="imagemAtualizada" id="imagemAtualizada">                                      					
                    </div> 				
				</div>				

			</div>

		</div><!--form-group-->

		<div class="form-group">
			<input type="submit" name="acao" value="Atualizar">
            <input type="hidden" name="id" value="<?php echo $produtosPedido['id']; ?>">
			<input type="hidden" name="imagemProduto" value="<?php echo $produtosPedido['img']; ?>">
		</div><!--form-group-->  

	</form>

</div><!--box-content-produto-->