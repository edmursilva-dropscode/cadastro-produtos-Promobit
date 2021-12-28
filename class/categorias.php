<?php
	
	class CategoriasProduto 
	{
			
		//cadastra nova categoria  
		public static function cadastrarCategorias($descricao){ 
			//total de categorias na base
			$TotalCategorias = MySql::conectar()->prepare("SELECT Count(*) + 1 AS total FROM tb_site_categorias");
			$TotalCategorias->execute();
			if($TotalCategorias->rowCount() == 1){
				$info = $TotalCategorias->fetch();
				//dados da base
				$total = $info['total'];                 
			}else{
				$info = $TotalCategorias->fetch();
				//dados da base
				$total = '1'; 
			} 
			//				
			$sql = MySql::conectar()->prepare("INSERT INTO tb_site_categorias VALUES (null,?,?)");
			if($sql->execute(array($descricao,$total))){ 
				return true;
			}else{
				return false;
			}
		}

		//altera a categoria da lista atraves do campo ID
		public static function alterarCategoria($id,$descricao){						
			$query = "UPDATE tb_site_categorias SET descricao = '{$descricao}'";			
			$sql = MySql::conectar()->prepare($query.' WHERE id=?');
			if($sql->execute(array($id))){ 
				return true;
			}else{
				return false;
			}			
		} 

		//deleta a categoria da lista atraves do campo ID 
		public static function deletarCategoria($tabela,$id=false){
			if($id == false){
				$sql = MySql::conectar()->prepare("DELETE FROM $tabela");
			}else{
				$sql = MySql::conectar()->prepare("DELETE FROM $tabela WHERE id = $id");
			}
			$sql->execute();
		}			

		//metodo especifico para selecionar apenas 1 registro da tabela 
		public static function selecionarCategoria($table,$query,$arr){
			$sql = MySql::conectar()->prepare("SELECT * FROM $table WHERE $query");
			$sql->execute($arr);
			return $sql->fetch();
		}		

	} 

?>