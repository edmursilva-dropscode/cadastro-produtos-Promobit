<div class="box-content-usuario">
	
    <h2><i class="bi bi-people-fill"></i> Adicionar Usuário</h2>

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
				$fotoUsuario = $_FILES['imagemUsuario'];				
				$id_perfil = $_POST['id_perfil'];

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
				}else if($fotoUsuario['name'] == ''){
					Painel::alert('erro','A imagem precisa estar selecionada!');                    
				}else{
					//valida campos chaves do formulario 
					if($senha != $validarSenha){
						Painel::alert('erro','Senhas diferentes, favor tende novamente!');                        
					}else if(AdminUsuarios::imagemValida($fotoUsuario) == false){
						Painel::alert('erro','O formato especificado não está correto!');
					}else{
						//valida campos chaves do formulario 
						if(AdminUsuarios::imagemValida($fotoUsuario) == false){
							Painel::alert('erro','O formato especificado não está correto!');							
						}else{		
							//valida se existe nome do usuario já cadastrado
							$verifica = MySql::conectar()->prepare("SELECT * FROM tb_admin_usuarios WHERE usuario=?");
							$verifica->execute(array($login));
							if($verifica->rowCount() == 0){											
								//cadastrar o usuario no bando de dados  
								$fotoUsuario = AdminUsuarios::uploadFile($fotoUsuario);
								if($adminUsuarios->cadastrarUsuarios($login,$senha,$fotoUsuario,$nome,$id_perfil)){
									Painel::alert('sucesso','O cadastro do usuário  foi feito com sucesso!');                        	
								}else{
									Painel::alert('erro','Erro ao cadastrar o usuário!');
								}
							}else{
								Painel::alert('erro','Já existe um usuário com esse login!');
							}								
						}						
					}
				}
				echo "<meta HTTP-EQUIV='refresh' CONTENT='4'>";
			}
		?>

		<div class="form-group">
			<label>Login:</label>
			<input type="text" name="usuario">
		</div><!--form-group-->

		<div class="form-group">
			<label>Nome:</label>
			<input type="text" name="nome"> 
		</div><!--form-group-->
		<div class="form-group">
			<label>Senha:</label>
			<input type="password" name="password" autocomplete="off" >
		</div><!--form-group-->
		<div class="form-group">
			<label>Confirmar Senha:</label>
			<input type="password" name="valid-password" autocomplete="off" >
		</div><!--form-group-->

		<div class="form-group">
			<label>Perfil:</label>
            <select name="id_perfil">
				<option value="">Seleciona um item</option> 
                <?php
                    $id_perfil = Painel::selectAll('tb_site_perfis');
                    foreach ($id_perfil as $key => $value) {
                ?>
                <option <?php if($value['id'] == @$_POST['id_perfil']) echo 'selected'; ?> value="<?php echo $value['id'] ?>"><?php echo $value['descricao']; ?></option>
                <?php } ?>
            </select>			
		</div><!--form-group-->

		<div class="form-group"> 

			<div class="row">
				
				<div class="box-imagem0">

					<div class="box-imagem1">
						
						<div class="imagem-usuario">
							<i class="bi bi-person-fill"></i><!--avatar-usuario--> 
							<img id="imagem-upload-usuario" alt><!--imagem-usuario--> 
						</div>
							
						<label>Imagem</label>
					</div> 				
					
					<input type="file" name="imagemUsuario" id="imagemUsuario">                                    
				</div>				

			</div>

		</div><!--form-group-->

		<div class="form-group">
			<input type="submit" name="acao" value="Cadastrar">
		</div><!--form-group-->

	</form>

</div><!--box-content-usuario-->