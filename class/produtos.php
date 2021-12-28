<?php
	
	class ProdutosPedido 
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
        
		//valida o caminho padrao do site para upload de imagens/foto do produto do site      
		public static function uploadFile($file){
			$formatoArquivo = explode('.',$file['name']);
			$imagemNome = uniqid().'.'.$formatoArquivo[count($formatoArquivo) - 1];				
			if(move_uploaded_file($file['tmp_name'],BASE_DIR_PATH.'/uploads/produtos/'.$imagemNome))					
				return $imagemNome;
			else
				return false;
		}

		//apaga a foto do produto do site
		public static function deletarFotoProduto($file){		
			if(file_exists(BASE_DIR_PATH.'/uploads/produtos/'.$file )) {
				if(@unlink(BASE_DIR_PATH.'/uploads/produtos/'.$file))
					return true;
				else
					return false;
			}else{
				return true;
			}
		}			

		//cadastra novo produto
		public static function cadastrarProdutos($descricao,$id_categoria,$fotoProduto,$preco){
			//total de produtos na base
			 $TotalProdutos = MySql::conectar()->prepare("SELECT Count(*) + 1 AS total FROM tb_site_produtos");
			 $TotalProdutos->execute();
			if($TotalProdutos->rowCount() == 1){
				$info = $TotalProdutos->fetch();
				//dados da base
				$total = $info['total'];                 
			}else{
				$info = $TotalProdutos->fetch();
				//dados da base
				$total = '1'; 
			} 
			//					
			$sql = MySql::conectar()->prepare("INSERT INTO tb_site_produtos VALUES (null,?,?,?,?,?)");
			if($sql->execute(array($descricao,$id_categoria,$fotoProduto,$preco,$total))){ 
				return true;
			}else{
				return false;
			}
		}

		//altera o produto da lista atraves do campo ID
		public static function alterarProdutos($id,$descricao,$id_categoria,$fotoProduto,$preco){			
			$query = "UPDATE tb_site_produtos SET descricao = '{$descricao}', id_categoria = '{$id_categoria}', img = '{$fotoProduto}', preco = '{$preco}'";			
			$sql = MySql::conectar()->prepare($query.' WHERE id=?');
			if($sql->execute(array($id))){ 
				return true;
			}else{
				return false;
			}			
		} 

		//deleta o produto da lista atraves do campo ID  
		public static function deletarProduto($tabela,$id=false){
			if($id == false){
				$sql = MySql::conectar()->prepare("DELETE FROM $tabela");
			}else{
				$sql = MySql::conectar()->prepare("DELETE FROM $tabela WHERE id = $id");
			}
			$sql->execute();
		}			

		//metodo especifico para selecionar apenas 1 registro da tabela 
		public static function selecionarProduto($table,$query,$arr){
			$sql = MySql::conectar()->prepare("SELECT * FROM $table WHERE $query");
			$sql->execute($arr);
			return $sql->fetch();
		}				

	} 

?>