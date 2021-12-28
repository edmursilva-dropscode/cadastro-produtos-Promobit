<?php

    ////configuracao do relatorio PDF 
    //require_once BASE_DIR_PATH.'/providers/dompdf/vendor/autoload.php';
	////referenciando o namespace da dompdf 
	//use Dompdf\Dompdf;

	//total de produtos
	$TotalProdutos = MySql::conectar()->prepare("SELECT * FROM tb_site_produtos WHERE ID > 0");
	$TotalProdutos->execute();
	$TotalProdutos = $TotalProdutos->fetchAll();

    //total de tags
	$TotalTags = MySql::conectar()->prepare("SELECT * FROM tb_site_tags WHERE ID > 0");
	$TotalTags->execute();
	$TotalTags = $TotalTags->fetchAll();	

    //total de categorias
	$TotalProdutosTags = MySql::conectar()->prepare("SELECT * FROM tb_site_produtos_tags WHERE ID > 0");
	$TotalProdutosTags->execute();
	$TotalProdutosTags = $TotalProdutosTags->fetchAll();	

?>

<!--exibe total de produtos, tags e categorias-->            
<div class="box-content-home w100"> 

    <div class="descricao-painel">
        <h2><i class="bi bi-house-fill"></i> Gestão de Produtos - <?php echo NOME_EMPRESA ?></h2>
    </div>

    <div class="box-metricas">  
            
        <div class="box-metrica-single"> 
            <div class="box-metrica-wraper">
                <h2>Total Produtos</h2>                
				<p><?php echo count($TotalProdutos); ?></p>
            </div>                                
        </div>
        
        <div class="box-metrica-single">
            <div class="box-metrica-wraper">
                <h2>Total Tags</h2>
                <p><?php echo count($TotalTags); ?></p>
            </div>                                
        </div>	

        <div class="box-metrica-single">
            <div class="box-metrica-wraper">
                <h2>Total Grupos</h2>
                <p><?php echo count($TotalProdutosTags); ?></p>
            </div>                                
        </div>			

        <div class="clear"></div><!--limpa flutuações-->

    </div>

	<!--cadastro-de-produtos-e-tags-------------------------------------------------------------------------------------------------------------------------->
	<div class="box-content-produto-tag">

		<h2><i class="bi bi-menu-button-wide-fill"></i> Montar grupos com Produtos e Tags</h2>

		<form method="post" enctype="multipart/form-data"> <!--sem este atributo ENCTYPE, nao funciona o upload da imagem-->

			<!--valida envio do formulario montar-produto-tag-->         
			<?php

				//verifica se existe o metodo ACAO, para enviar o formulario montar       
				if(isset($_POST['acao'])){

					//variaveis de controle
					$id_produto = $_POST['id_produto'];
					$id_tag = $_POST['id_tag'];
					$data = $_POST['data'];

					//instancia a classe PRODUTOSTAGS   
					$produtosTags = new ProdutosTags(); 

					//valida todos os campos do formulario  
					if($id_produto == ''){
						Painel::alert('erro','O produto está vázia!');
					}else if($id_tag == ''){
						Painel::alert('erro','A tag está vázia!');				
					}else{
						//valida se existe descricao de produto já cadastrado  
						$verifica = MySql::conectar()->prepare("SELECT * FROM tb_site_produtos_tags WHERE id_produto=? AND id_tag = ?");
						$verifica->execute(array($id_produto,$id_tag));
						if($verifica->rowCount() == 0){
							//cadastrar o produto e tag no bando de dados 
							if($produtosTags->cadastrarProdutosTags($id_produto,$id_tag,$data)){								
								Painel::alert('sucesso','O grupo foi cadastrado com sucesso!');  							                     	
							}else{
								Painel::alert('erro','Erro ao cadastrar o grupo!');
							}
						}else{
							Painel::alert('erro','Já existe um produto com esta tag!');
						}
					} 	
					echo "<meta HTTP-EQUIV='refresh' CONTENT='4'>";								
				}						
			?>

			<div class="form-group">
				<label>Produto:</label>
				<select name="id_produto">
					<option value="">Seleciona um item</option> 
					<?php
						$id_produto = Painel::selectAll('tb_site_produtos');
						foreach ($id_produto as $key => $value) {
					?>
					<option <?php if($value['id'] == @$_POST['id_produto']) echo 'selected'; ?> value="<?php echo $value['id'] ?>"><?php echo $value['descricao']; ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="form-group">
				<label>Tag:</label>
				<select name="id_tag">
					<option value="">Seleciona um item</option> 
					<?php
						$id_tag = Painel::selectAll('tb_site_tags');
						foreach ($id_tag as $key => $value) {
					?>
					<option <?php if($value['id'] == @$_POST['id_tag']) echo 'selected'; ?> value="<?php echo $value['id'] ?>"><?php echo $value['descricao']; ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="form-group">
				<br>
				<input type="submit" name="acao" value="Montar">
				<input type="hidden" name="data" id="data" value="<?php echo date('d-m-y H:i:s'); ?>">
			</div><!--form-group-->  

		</form>

	</div><!--box-content-produto-tag-->

	<!--lista-de-produtos-tags--------------------------------------------------------------------------------------------------------------------------------------------->
	<?php

		//valida acao excluir
		if(isset($_GET['excluir'])){
			//seleciona o usuario pelo ID
			$idExcluir = intval($_GET['excluir']);
			//busca informacao do produto e tag
			$produtosTags = ProdutosTags::selecionarProdutosTags('tb_site_produtos_tags','id = ?',array($idExcluir));
			//DELETA PRODUTO E TAG
			ProdutosTags::deletarProdutosTags('tb_site_produtos_tags',$idExcluir);
			//redireciona a url do site para listar-protutos-tags
			Painel::redirect(INCLUDE_PATH_PAINEL.'home');
		//valida acao imprimir
		}else if(isset($_GET['imprimir'])){						
			//seleciona o usuario pelo ID
			$idImprimir = intval($_GET['imprimir']);
			//busca informacao do produto e tag 
			$produtosTags = ProdutosTags::selecionarProdutosTags('tb_site_produtos_tags','id = ?',array($idImprimir));
			
		}

		//valida pagina de exibicao  
		$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; 
		$porPagina = 5;

		$produtosTags = Painel::selectAll('tb_site_produtos_tags',($paginaAtual - 1) * $porPagina,$porPagina);

	?>
	<div class="box-content-listar-produtos-tags">
		
		<h2><i class="bi bi-bar-chart-line-fill"></i> Lista dos Grupos</h2>

		<div class="wraper-table">
			<table>
				<tr>
					<td>Data</td>
					<td>Produto</td>
					<td>Imagem</td>
					<td>Tag</td>
					<td></td>
				</tr>

					<?php
						//lista todos registros da variavel $produtosTags 
						foreach ($produtosTags as $key => $value) {
						$descricaoProduto = Painel::select('tb_site_produtos','id=?',array($value['id_produto']))['descricao'];
						$imgProduto = Painel::select('tb_site_produtos','id=?',array($value['id_produto']))['img'];
						$descricaoTag = Painel::select('tb_site_tags','id=?',array($value['id_tag']))['descricao'];
					?>		

					<tr>
						<td><?php echo $value['data']; ?></td>
						<td><?php echo $descricaoProduto; ?></td>
						<td><img style="width: 80px;height:60px;" src="<?php echo INCLUDE_PATH_PAINEL ?>/uploads/produtos/<?php echo $imgProduto; ?>" /></td>
						<td><?php echo $descricaoTag; ?></td>												
						<td><a actionBtn="delete" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>home?excluir=<?php echo $value['id']; ?>"><i class="bi bi-trash-fill"></i> Excluir</a></td>
					</tr>        

				<?php } ?>

			</table>
		</div>

		<div class="paginacao">
			<?php
				$totalPaginas = ceil(count(Painel::selectAll('tb_site_produtos_tags')) / $porPagina);

				for($i = 1; $i <= $totalPaginas; $i++){
					if($i == $paginaAtual)
						echo '<a class="page-selected" href="'.INCLUDE_PATH_PAINEL.'home?pagina='.$i.'">'.$i.'</a>';
					else
						echo '<a href="'.INCLUDE_PATH_PAINEL.'home?pagina='.$i.'">'.$i.'</a>';
				}

			?>
		</div><!--paginacao-->	

	</div><!--box-content-listar-produtos-tags--> 

</div><!--box-content-home-->
