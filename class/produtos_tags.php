<?php
	
	class ProdutosTags
	{
			
		//cadastra novo produto e tag
		public static function cadastrarProdutosTags($id_produto,$id_tag,$data){
			$sql = MySql::conectar()->prepare("INSERT INTO tb_site_produtos_tags VALUES (null,?,?,?)");
			if($sql->execute(array($id_produto,$id_tag,$data))){ 
				return true;
			}else{
				return false;
			}
		}

		//deleta o pedido da lista atraves do campo ID     
		public static function deletarProdutosTags($tabela,$id=false){
			if($id == false){
				$sql = MySql::conectar()->prepare("DELETE FROM $tabela");
			}else{
				$sql = MySql::conectar()->prepare("DELETE FROM $tabela WHERE id = $id");
			}
			$sql->execute();
		}			

		//metodo especifico para selecionar apenas 1 registro da tabela 
		public static function selecionarProdutosTags($table,$query,$arr){
			$sql = MySql::conectar()->prepare("SELECT * FROM $table WHERE $query");
			$sql->execute($arr);
			return $sql->fetch();
		}				

	} 

?>