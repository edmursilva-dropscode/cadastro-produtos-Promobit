<?php

	//valida acao excluir 
	if(isset($_GET['excluir'])){
		//seleciona a categoria pelo ID
		$idExcluir = intval($_GET['excluir']);
		//busca informacao da categoria
		$categoriasProduto = CategoriasProduto::selecionarCategoria('tb_site_categorias','id = ?',array($idExcluir));
		//DELETA CATEGORIAS
		CategoriasProduto::deletarCategoria('tb_site_categorias',$idExcluir);
		//redireciona a url do site para listar-categorias 
		Painel::redirect(INCLUDE_PATH_PAINEL.'listar-categorias');		
	}else if(isset($_GET['order']) && isset($_GET['id'])){
		Painel::orderItem('tb_site_categorias',$_GET['order'],$_GET['id']);		
	}

	//valida pagina de exibicao
	$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; 
	$porPagina = 10;

	$categoriasPainel = painel::selectAllOrderId('tb_site_categorias',($paginaAtual - 1) * $porPagina,$porPagina);
	
?>
<div class="box-content-listar-categorias">
	
    <h2><i class="bi bi-ui-checks"></i> Categorias Cadastradas</h2> 

	<div class="wraper-table">
		<table>
			<tr>
				<td>Descrição</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>				
			</tr>

			<?php
				//lista todos registros da variavel $categoriasPainel
				foreach ($categoriasPainel as $key => $value) {
			?>			
				<tr>
					<td><?php echo $value['descricao']; ?></td>
					<td><a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-categorias?id=<?php echo $value['id']; ?>"><i class="bi bi-pencil-square"></i> Editar</a></td>
					<td><a actionBtn="delete" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-categorias?excluir=<?php echo $value['id']; ?>"><i class="bi bi-trash-fill"></i> Excluir</a></td>
					<td><a class="btn order" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-categorias?order=up&id=<?php echo $value['id'] ?>"><i class="bi bi-caret-up-square-fill"></i></a></td>
					<td><a class="btn order" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-categorias?order=down&id=<?php echo $value['id'] ?>"><i class="bi bi-caret-down-square-fill"></i></a></td>
				</tr>        
			<?php } ?>

		</table>
	</div>

	<div class="paginacao">
		<?php
			$totalPaginas = ceil(count(Painel::selectAllOrderId('tb_site_categorias')) / $porPagina);

			for($i = 1; $i <= $totalPaginas; $i++){
				if($i == $paginaAtual)
					echo '<a class="page-selected" href="'.INCLUDE_PATH_PAINEL.'listar-categorias?pagina='.$i.'">'.$i.'</a>';
				else
					echo '<a href="'.INCLUDE_PATH_PAINEL.'listar-categorias?pagina='.$i.'">'.$i.'</a>';
			}

		?>
	</div><!--paginacao-->	

</div><!--box-content-listar-categorias--> 