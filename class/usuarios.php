<?php
	
	class AdminUsuarios
	{

		//valida tipo de imagem e tamanho     
		public static function imagemValida($imagem){
			if($imagem['type'] == 'image/jpeg' ||
				$imagem['type'] == 'imagem/jpg' ||
				$imagem['type'] == 'imagem/png'){

				$tamanho = intval($imagem['size']/1080);
				if($tamanho < 1930)
					return true;
				else
					return false;
			}else{
				return false;
			}
		}    

		//valida o caminho padrao do site para upload de imagens/foto do usuario do site         
		public static function uploadFile($file){
			$formatoArquivo = explode('.',$file['name']);
			$imagemNome = uniqid().'.'.$formatoArquivo[count($formatoArquivo) - 1];				
			if(move_uploaded_file($file['tmp_name'],BASE_DIR_PATH.'/uploads/user/'.$imagemNome))					
				return $imagemNome;
			else
				return false;
		}		

		//apaga a foto do usuario do site 
		public static function deletarFotoUsuario($file){		
			if(file_exists(BASE_DIR_PATH.'/uploads/user/'.$file )) {
				if(@unlink(BASE_DIR_PATH.'/uploads/user/'.$file))
					return true;
				else
					return false;
			}else{
				return true;
			}
		}	

		//cadastrar novo usuario
		public static function cadastrarUsuarios($usuario,$senha,$fotoUsuario,$nome,$perfil){
			//total de usuarios na base
			$TotalUsuarios = MySql::conectar()->prepare("SELECT Count(*) + 1 AS total FROM tb_admin_usuarios");
			$TotalUsuarios->execute();
			if($TotalUsuarios->rowCount() == 1){
				$info = $TotalUsuarios->fetch();
				//dados da base
				$total = $info['total'];                 
			}else{
				$info = $TotalUsuarios->fetch();
				//dados da base
				$total = '1'; 
			} 
			//			
			$sql = MySql::conectar()->prepare("INSERT INTO tb_admin_usuarios VALUES (null,?,?,?,?,?,?)");
			if($sql->execute(array($usuario,$senha,$fotoUsuario,$nome,$perfil,$total))){
				return true;
			}else{
				return false;
			}
		}

        //altera o usuario da lista atraves do campo ID
		public static function alterarUsuarios($id,$usuario,$senha,$fotoUsuario,$nome,$perfil){
			$query = "UPDATE tb_admin_usuarios SET usuario = '{$usuario}', senha = '{$senha}', img = '{$fotoUsuario}', nome = '{$nome}', id_perfil = '{$perfil}'";			
			$sql = MySql::conectar()->prepare($query.' WHERE id=?');
			if($sql->execute(array($id))){ 
				return true;
			}else{
				return false;
			}	
		} 

		//deleta o usuario da lista atraves do campo ID  
		public static function deletarUsuario($tabela,$id=false){
			if($id == false){
				$sql = MySql::conectar()->prepare("DELETE FROM $tabela");
			}else{
				$sql = MySql::conectar()->prepare("DELETE FROM $tabela WHERE id = $id");
			}
			$sql->execute();
		}	
		
		//metodo especifico para selecionar apenas 1 registro da tabela 
		public static function selecionarUsuario($table,$query,$arr){
			$sql = MySql::conectar()->prepare("SELECT * FROM $table WHERE $query");
			$sql->execute($arr);
			return $sql->fetch();
		}		

	} 

?>