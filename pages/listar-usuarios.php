<?php

	//valida acai excluir 
	if(isset($_GET['excluir'])){
		//seleciona o usuario pelo ID
		$idExcluir = intval($_GET['excluir']);
		//busca informacao do usuario
		$adminUsuarios = AdminUsuarios::selecionarUsuario('tb_admin_usuarios','id = ?',array($idExcluir));
		//Valida se existe a foto e exclui 
		if(AdminUsuarios::deletarFotoUsuario($adminUsuarios['img'])){
			//DELETA USUARIO
			AdminUsuarios::deletarUsuario('tb_admin_usuarios',$idExcluir);
		}
		//redireciona a url do site para listar-usuarios 
		Painel::redirect(INCLUDE_PATH_PAINEL.'listar-usuarios');
	}else if(isset($_GET['order']) && isset($_GET['id'])){
		Painel::orderItem('tb_admin_usuarios',$_GET['order'],$_GET['id']);		
	}

	//valida pagina de exibicao
	$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; 
	$porPagina = 10;

	$usuariosPainel = painel::selectAllOrderId('tb_admin_usuarios',($paginaAtual - 1) * $porPagina,$porPagina);
	
?>
<div class="box-content-listar-usuarios">
	
	<h2><i class="bi bi-people-fill"></i> Usuarios Cadastrados</h2>

	<div class="wraper-table">
		<table>
			<tr>
				<td>Nome</td>
				<td>Perfil</td>
				<td>Imagem</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>				
			</tr>

			<?php
				//lista todos registros da variavel $usuariosPainel
				foreach ($usuariosPainel as $key => $value) {				
				$descricaoPerfil = Painel::select('tb_site_perfis','id=?',array($value['id_perfil']))['descricao'];
			?>			
				<tr>
					<td><?php echo $value['nome']; ?></td>
					<td><?php echo $descricaoPerfil; ?></td>
					<td><img style="width: 100px;height:70px;" src="<?php echo INCLUDE_PATH_PAINEL ?>/uploads/user/<?php echo $value['img']; ?>" /></td>
					<td><a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-usuarios?id=<?php echo $value['id']; ?>"><i class="bi bi-pencil-square"></i> Editar</a></td>
					<td><a actionBtn="delete" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-usuarios?excluir=<?php echo $value['id']; ?>"><i class="bi bi-trash-fill"></i> Excluir</a></td>
					<td><a class="btn order" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-usuarios?order=up&id=<?php echo $value['id'] ?>"><i class="bi bi-caret-up-square-fill"></i></a></td>
					<td><a class="btn order" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-usuarios?order=down&id=<?php echo $value['id'] ?>"><i class="bi bi-caret-down-square-fill"></i></a></td>
				</tr>        
			<?php } ?>

		</table>
	</div>

	<div class="paginacao">
		<?php
			$totalPaginas = ceil(count(Painel::selectAllOrderId('tb_admin_usuarios')) / $porPagina);

			for($i = 1; $i <= $totalPaginas; $i++){
				if($i == $paginaAtual)
					echo '<a class="page-selected" href="'.INCLUDE_PATH_PAINEL.'listar-usuarios?pagina='.$i.'">'.$i.'</a>';
				else
					echo '<a href="'.INCLUDE_PATH_PAINEL.'listar-usuarios?pagina='.$i.'">'.$i.'</a>';
			}

		?>
	</div><!--paginacao-->	

</div><!--box-content-listar-usuarios--> 

