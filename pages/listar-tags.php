<?php

	//valida acao excluir 
	if(isset($_GET['excluir'])){
		//seleciona a tag pelo ID
		$idExcluir = intval($_GET['excluir']);
		//busca informacao da tag
		$tagsProduto = TagsProduto::selecionarTag('tb_site_tags','id = ?',array($idExcluir)); 
		//DELETA TAGS 
		TagsProduto::deletarTag('tb_site_tags',$idExcluir);
		//redireciona a url do site para listar-tags 
		Painel::redirect(INCLUDE_PATH_PAINEL.'listar-tags');		
	}else if(isset($_GET['order']) && isset($_GET['id'])){
		Painel::orderItem('tb_site_tags',$_GET['order'],$_GET['id']);		
	}

	//valida pagina de exibicao
	$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; 
	$porPagina = 10;

	$tagsPainel = painel::selectAllOrderId('tb_site_tags',($paginaAtual - 1) * $porPagina,$porPagina);
	
?>
<div class="box-content-listar-tags">
	
	<h2><i class="bi bi-tags-fill"></i> Tags Cadastradas</h2>

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
				//lista todos registros da variavel $tagsPainel
				foreach ($tagsPainel as $key => $value) {
			?>			
				<tr>
					<td><?php echo $value['descricao']; ?></td>
					<td><a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-tags?id=<?php echo $value['id']; ?>"><i class="bi bi-pencil-square"></i> Editar</a></td>
					<td><a actionBtn="delete" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-tags?excluir=<?php echo $value['id']; ?>"><i class="bi bi-trash-fill"></i> Excluir</a></td>
					<td><a class="btn order" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-tags?order=up&id=<?php echo $value['id'] ?>"><i class="bi bi-caret-up-square-fill"></i></a></td>
					<td><a class="btn order" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-tags?order=down&id=<?php echo $value['id'] ?>"><i class="bi bi-caret-down-square-fill"></i></a></td>
				</tr>        
			<?php } ?>

		</table>
	</div>

	<div class="paginacao">
		<?php
			$totalPaginas = ceil(count(Painel::selectAllOrderId('tb_site_tags')) / $porPagina);

			for($i = 1; $i <= $totalPaginas; $i++){
				if($i == $paginaAtual)
					echo '<a class="page-selected" href="'.INCLUDE_PATH_PAINEL.'listar-tags?pagina='.$i.'">'.$i.'</a>';
				else
					echo '<a href="'.INCLUDE_PATH_PAINEL.'listar-tags?pagina='.$i.'">'.$i.'</a>';
			}

		?>
	</div><!--paginacao-->	

</div><!--box-content-listar-tags--> 