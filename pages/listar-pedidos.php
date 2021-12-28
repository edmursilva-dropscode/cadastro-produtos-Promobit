<?php

	//valida acao excluir
	if(isset($_GET['excluir'])){
		//seleciona o usuario pelo ID
		$idExcluir = intval($_GET['excluir']);
		//busca informacao do pedido
		$comandasPedido = ComandasPedido::selecionarPedido('tb_site_pedidos','id = ?',array($idExcluir));
        //DELETA PEDIDO
        ComandasPedido::deletarPedido('tb_site_pedidos',$idExcluir);
		//redireciona a url do site para listar-pedidos   
		Painel::redirect(INCLUDE_PATH_PAINEL.'listar-pedidos');
	}else if(isset($_GET['order']) && isset($_GET['id'])){
		Painel::orderItem('tb_site_pedidos',$_GET['order'],$_GET['id']);		
	}

	//valida pagina de exibicao 
	$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; 
	$porPagina = 10;

	$pedidosPainel = painel::selectAll('tb_site_pedidos',null,($paginaAtual - 1) * $porPagina,$porPagina);
	
?>
<div class="box-content-listar-pedidos">
	
    <h2><i class="bi bi-pencil-square"></i> Pedidos Cadastrados</h2>

	<div class="wraper-table">
		<table>
            <tr>
                <td>Pedido</td>
                <td>Data</td>
				<td>Nome</td>
                <td>Comanda</td>
                <td>Atendente</td>                
				<td>Status</td>
				<td></td>
				<td></td>			
			</tr>

                <?php
					//lista todos registros da variavel $pedidosPainel
					foreach ($pedidosPainel as $key => $value) {
                    $nomeAtendente = Painel::select('tb_admin_usuarios','id=?',array($value['id_usuario']))['nome'];
				?>		


				<tr>
                    <td><?php echo $value['id']; ?></td>
                    <td><?php echo $value['data_pedido']; ?></td>
					<td><?php echo $value['nome_cliente']; ?></td>
                    <td><?php echo $value['id_comanda']; ?></td>
					<td><?php echo $nomeAtendente; ?></td>
					<td>                      
                        <?php
                        if($value['status'] == '1'){
                        ?>
                            Aberto  
                        <?php }elseif($value['status'] == '2'){ ?>
                            Fechado  
                        <?php }elseif($value['status'] == '3'){ ?>
                            Pago     
                        <?php } ?>                               
                    </td>
					<td><a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-pedidos?id=<?php echo $value['id']; ?>"><i class="bi bi-pencil-square"></i> Editar</a></td>
					<td><a actionBtn="delete" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-pedidos?excluir=<?php echo $value['id']; ?>"><i class="bi bi-trash-fill"></i> Excluir</a></td>
				</tr>        
			<?php } ?>

		</table>
	</div>

	<div class="paginacao">
		<?php
			$totalPaginas = ceil(count(Painel::selectAll('tb_site_pedidos')) / $porPagina);

			for($i = 1; $i <= $totalPaginas; $i++){
				if($i == $paginaAtual)
					echo '<a class="page-selected" href="'.INCLUDE_PATH_PAINEL.'listar-pedidos?pagina='.$i.'">'.$i.'</a>';
				else
					echo '<a href="'.INCLUDE_PATH_PAINEL.'listar-pedidos?pagina='.$i.'">'.$i.'</a>';
			}

		?>
	</div><!--paginacao-->	

</div><!--box-content-listar-usuarios--> 