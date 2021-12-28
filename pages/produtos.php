<div class="box-content-produto">
	
    <h2><i class="bi bi-inboxes-fill"></i> Adicionar Produtos</h2>

	<form method="post" enctype="multipart/form-data"> <!--sem este atributo ENCTYPE, nao funciona o upload da imagem--> 

        <!-- valida envio do formulario adicionar-produto -->        
		<?php

            //verifica se existe o metodo ACAO, para enviar o formulario adicionar     
			if(isset($_POST['acao'])){

                //variaveis de controle
				$descricao = $_POST['descricao'];
				$id_categoria = $_POST['id_categoria'];
				$fotoProduto = $_FILES['imagemProduto'];
				$preco = $_POST['preco'];

				//echo '<script>alert("teste ")</script>';     

                //instancia a classe PRODUTO    
                $produtosPedido = new ProdutosPedido();

                //valida todos os campos do formulario    
				if($descricao == ''){
					Painel::alert('erro','A descricao está vázia!');
                }else if($id_categoria == ''){
					Painel::alert('erro','A categoria está vázia!');
                }else if($preco == ''){
					Painel::alert('erro','O preço está vázio!');				
				}else if($fotoProduto['name'] == ''){
					Painel::alert('erro','A imagem precisa estar selecionada!');
				}else{
					//valida campos chaves do formulario 
					if(ProdutosPedido::imagemValida($fotoProduto) == false){
						Painel::alert('erro','O formato especificado não está correto!');
					}else{
						//valida se existe descricao de produto já cadastrado  
						$verifica = MySql::conectar()->prepare("SELECT * FROM tb_site_produtos WHERE descricao=? AND id_categoria = ?");
						$verifica->execute(array($descricao,$id_categoria));
						if($verifica->rowCount() == 0){
							//cadastrar o produto no bando de dados 
							$fotoProduto = ProdutosPedido::uploadFile($fotoProduto);
							if($produtosPedido->cadastrarProdutos($descricao,$id_categoria,$fotoProduto,$preco)){								
								Painel::alert('sucesso','O cadastro do produto foi feito com sucesso!');  							                     	
							}else{
								Painel::alert('erro','Erro ao cadastrar o produto!');
							}
						}else{
							Painel::alert('erro','Já existe um produto com essa descrição!');
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
                <option <?php if($value['id'] == @$_POST['id_categoria']) echo 'selected'; ?> value="<?php echo $value['id'] ?>"><?php echo $value['descricao']; ?></option>
                <?php } ?>
            </select>
		</div>

		<div class="form-group">
			<label>Descricao:</label>
			<input type="text" name="descricao" value="<?php recoverPost('descricao'); ?>">
		</div><!--form-group--> 

		<div class="form-group">
			<label>Preço:</label>
			<input type="text" data-mask="000.000,00"  name="preco" value="<?php recoverPost('preco'); ?>">
		</div><!--form-group--> 

		<div class="form-group"> 

			<div class="row">
				
				<div class="box-produto0">

					<div class="box-produto1">
						
						<div class="imagem-produto">
							<i class="bi bi-image-fill"></i><!--avatar-imagem-produto-->  
							<img id="imagem-upload-produto" alt><!--imagem-produto-->
						</div>
							
						<label>Imagem</label>
					</div> 				
					
					<div class="box-produto2">
						<input type="file" name="imagemProduto" id="imagemProduto">                                    
					</div> 				

				</div>				

			</div>

		</div><!--form-group-->

		<div class="form-group">
			<input type="submit" name="acao" value="Cadastrar">
		</div><!--form-group-->  

	</form>

</div><!--box-content-produto-->