<?php

	//valida acai excluir 
	if(isset($_GET['excluir'])){
		//seleciona o produto pelo ID
		$idExcluir = intval($_GET['excluir']);
		//busca informacao do produto 
		$produtosPedido = ProdutosPedido::selecionarProduto('tb_site_produtos','id = ?',array($idExcluir));
		//Valida se existe a foto e exclui 
		if(ProdutosPedido::deletarFotoProduto($produtosPedido['img'])){
			//DELETA PRODUTO
			ProdutosPedido::deletarProduto('tb_site_produtos',$idExcluir);
		}
		//redireciona a url do site para listar-produtos  
		Painel::redirect(INCLUDE_PATH_PAINEL.'listar-produtos');
	}else if(isset($_GET['order']) && isset($_GET['id'])){
		Painel::orderItem('tb_site_produtos',$_GET['order'],$_GET['id']);		
	}

	//valida pagina de exibicao
	$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; 
	$porPagina = 10;

	$produtosPainel = painel::selectAllOrderId('tb_site_produtos',($paginaAtual - 1) * $porPagina,$porPagina);
	
?>
<div class="box-content-listar-produtos">
	
    <h2><i class="bi bi-inboxes-fill"></i> Produtos Cadastrados</h2> 

	<div class="wraper-table">
		<table>
			<tr>
				<td>Nome</td>
				<td>Categoria</td>
				<td>Imagem</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>				
			</tr>

			<?php
				//lista todos registros da variavel $produtosPainel  
				foreach ($produtosPainel as $key => $value) {
				$descricaoCategoria = Painel::select('tb_site_categorias','id=?',array($value['id_categoria']))['descricao'];
			?>			
				<tr>
					<td><?php echo $value['descricao']; ?></td>
					<td><?php echo $descricaoCategoria; ?></td>
					<td><img style="width: 100px;height:70px;" src="<?php echo INCLUDE_PATH_PAINEL ?>/uploads/produtos/<?php echo $value['img']; ?>" /></td>
					<td><a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-produtos?id=<?php echo $value['id']; ?>"><i class="bi bi-pencil-square"></i> Editar</a></td>
					<td><a actionBtn="delete" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-produtos?excluir=<?php echo $value['id']; ?>"><i class="bi bi-trash-fill"></i> Excluir</a></td>
					<td><a class="btn order" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-produtos?order=up&id=<?php echo $value['id'] ?>"><i class="bi bi-caret-up-square-fill"></i></a></td>
					<td><a class="btn order" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-produtos?order=down&id=<?php echo $value['id'] ?>"><i class="bi bi-caret-down-square-fill"></i></a></td>
				</tr>        
			<?php } ?>

		</table>
	</div>

	<div class="paginacao">
		<?php
			$totalPaginas = ceil(count(Painel::selectAllOrderId('tb_site_produtos')) / $porPagina);

			for($i = 1; $i <= $totalPaginas; $i++){
				if($i == $paginaAtual)
					echo '<a class="page-selected" href="'.INCLUDE_PATH_PAINEL.'listar-produtos?pagina='.$i.'">'.$i.'</a>';
				else
					echo '<a href="'.INCLUDE_PATH_PAINEL.'listar-produtos?pagina='.$i.'">'.$i.'</a>';
			}

		?>
	</div><!--paginacao-->	

</div><!--box-content-listar-produtos--> 