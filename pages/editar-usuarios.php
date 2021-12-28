<?php 
	if(isset($_GET['id'])){
		$id = (int)$_GET['id'];
		$adminUsuarios = AdminUsuarios::selecionarUsuario('tb_admin_usuarios','id = ?',array($id));
	}else{
		Painel::alert('erro','Você precisa passar o parametro ID.');
		die();
	}
 ?>
<div class="box-content-usuario">
	
    <h2><i class="bi bi-people-fill"></i> Editar Usuario</h2> 

	<form method="post" enctype="multipart/form-data"> <!--sem este atributo ENCTYPE, nao funciona o upload da imagem-->  

        <!-- valida envio do formulario adicionar-usuario -->        
		<?php

            //verifica se existe o metodo ACAO, para enviar o formulario adicionar        
			if(isset($_POST['acao'])){

                //variaveis de controle
				$login = $_POST['usuario'];
				$nome = $_POST['nome'];
				$senha = $_POST['password'];
				$validarSenha = $_POST['valid-password'];
				$imagemAtualizada = $_FILES['imagemAtualizada'];
				$fotoUsuario = $_POST['imagemUsuario'];				
				$id_perfil = $_POST['id_perfil'];

				//echo '<script>alert("teste ")</script>';

                //instancia a classe USUARIO   
                $adminUsuarios = new AdminUsuarios();

                //valida todos os campos do formulario
				if($login == ''){
					Painel::alert('erro','O login está vázio!');                    
                }else if($login != filter_var($login, FILTER_VALIDATE_EMAIL)){
					Painel::alert('erro','O login não é um email!');                    
				}else if($nome == ''){
					Painel::alert('erro','O nome está vázio!');                    
				}else if($senha == ''){
					Painel::alert('erro','A senha está vázia!');                    
				}else if($id_perfil == ''){
					Painel::alert('erro','O perfil precisa estar selecionado!');                                      
				}else{
					//valida campos chaves do formulario  
					if($senha != $validarSenha){
						Painel::alert('erro','Senhas diferentes, favor tende novamente!');                        
					}else{
						if($imagemAtualizada['name'] != ''){	

							//valida campos chaves do formulario  
							if(AdminUsuarios::imagemValida($imagemAtualizada) == false){
								Painel::alert('erro','O formato especificado não está correto!');
							}else{
								//valida se existe login de usuario já cadastrado
								$verifica = MySql::conectar()->prepare("SELECT * FROM tb_admin_usuarios WHERE usuario=? AND id != ?");
								$verifica->execute(array($login,$id));
								if($verifica->rowCount() == 0){
									//Valida se existe a foto antiga e exclui
									if(AdminUsuarios::deletarFotoUsuario($fotoUsuario)){
										//alterar o usuario no bando de dados  
										$imagemAtualizada = AdminUsuarios::uploadFile($imagemAtualizada);										
										if($adminUsuarios->alterarUsuarios($id,$login,$senha,$imagemAtualizada,$nome,$id_perfil)){
											Painel::alert('sucesso','Usuário foi alterado com sucesso!');                        	
											$adminUsuarios = AdminUsuarios::selecionarUsuario('tb_admin_usuarios','id = ?',array($id));                     	
										}else{
											Painel::alert('erro','Erro ao alterar o usuário!');
										}
									}else{
										Painel::alert('erro','Erro ao alterar o usuário!');
									}
								}else{
									Painel::alert('erro','Já existe um usuário com esse login!');
									$adminUsuarios = AdminUsuarios::selecionarUsuario('tb_admin_usuarios','id = ?',array($id));  
								}								
							}						
						}else{
							//valida se existe login de usuario já cadastrado  
							$verifica = MySql::conectar()->prepare("SELECT * FROM tb_admin_usuarios WHERE usuario=? AND id != ?");
							$verifica->execute(array($login,$id));
							if($verifica->rowCount() == 0){						
								//alterar o produto no bando de dados   								
								if($adminUsuarios->alterarUsuarios($id,$login,$senha,$fotoUsuario,$nome,$id_perfil)){
									Painel::alert('sucesso','Usuário foi alterado com sucesso!');   
									$adminUsuarios = AdminUsuarios::selecionarUsuario('tb_admin_usuarios','id = ?',array($id));                     	
								}else{
									Painel::alert('erro','Erro ao alterar o usuário!');
								}
							}else{
								Painel::alert('erro','Já existe um usuário com esse login!');
								$adminUsuarios = AdminUsuarios::selecionarProduto('tb_admin_usuarios','id = ?',array($id));  
							}	
						}
					}
				} 				
				echo "<meta HTTP-EQUIV='refresh' CONTENT='4'>";				
			}
		?>

		<div class="form-group">
			<label>Login:</label>
			<input type="text" name="usuario" value="<?php echo $adminUsuarios['usuario']; ?>">
		</div><!--form-group-->

		<div class="form-group">
			<label>Nome:</label>
			<input type="text" name="nome" value="<?php echo $adminUsuarios['nome']; ?>">
		</div><!--form-group-->
		<div class="form-group">
			<label>Senha:</label>
			<input type="password" name="password" autocomplete="off" value="<?php echo $adminUsuarios['senha']; ?>">
		</div><!--form-group--> 
		<div class="form-group">
			<label>Confirmar Senha:</label>
			<input type="password" name="valid-password" autocomplete="off" value="<?php echo $adminUsuarios['senha']; ?>">
		</div><!--form-group-->

		<div class="form-group">
            <label>Perfil:</label>
            <select name="id_perfil">
                <?php
                    $id_perfil = Painel::selectAll('tb_site_perfis');
                    foreach ($id_perfil as $key => $value) {
                ?>
                <option <?php if($value['id'] == $adminUsuarios['id_perfil']) echo 'selected'; ?> value="<?php echo $value['id'] ?>"><?php echo $value['descricao']; ?></option>
                <?php } ?>
            </select>
		</div>		

		<div class="form-group"> 

			<div class="row">
				
				<div class="box-usuario0">

					<div class="box-usuario1">
						
						<div class="imagem-usuario">
							<i class="bi bi-image-fill"></i><!--avatar-produto-->    
							<img src="<?php echo INCLUDE_PATH_PAINEL ?>/uploads/user/<?php echo $adminUsuarios['img']; ?>" id="imagem-upload-usuario" alt><!--imagem-produto-->
						</div>
							
						<label>Imagem</label>
					</div> 				
					
                    <div class="box-usuario2">
					    <input type="file" name="imagemAtualizada" id="imagemAtualizada">                                      					
                    </div> 				
				</div>				

			</div>

		</div><!--form-group-->

		<div class="form-group">
			<input type="submit" name="acao" value="Atualizar">
            <input type="hidden" name="id" value="<?php echo $adminUsuarios['id']; ?>">
			<input type="hidden" name="imagemUsuario" value="<?php echo $adminUsuarios['img']; ?>">
		</div><!--form-group-->

	</form>

</div><!--box-content-produto-->