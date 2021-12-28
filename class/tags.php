<?php
	
	class TagsProduto
	{
			
		//cadastra nova tag
		public static function cadastrarTags($descricao){
			//total de tags na base
			$TotalTags = MySql::conectar()->prepare("SELECT Count(*) + 1 AS total FROM tb_site_tags");
			$TotalTags->execute();
			if($TotalTags->rowCount() == 1){
				$info = $TotalTags->fetch();
				//dados da base
				$total = $info['total'];                 
			}else{
				$info = $TotalTags->fetch();
				//dados da base
				$total = '1'; 
			} 
			//			
			$sql = MySql::conectar()->prepare("INSERT INTO tb_site_tags VALUES (null,?,?)");
			if($sql->execute(array($descricao,$total))){ 
				return true;
			}else{
				return false;
			}
		}

		//altera a tag da lista atraves do campo ID  
		public static function alterarTag($id,$descricao){			
			$query = "UPDATE tb_site_tags SET descricao = '{$descricao}'";			
			$sql = MySql::conectar()->prepare($query.' WHERE id=?');
			if($sql->execute(array($id))){ 
				return true;
			}else{
				return false;
			}			
		} 

		//deleta a tag da lista atraves do campo ID 
		public static function deletarTag($tabela,$id=false){
			if($id == false){
				$sql = MySql::conectar()->prepare("DELETE FROM $tabela");
			}else{
				$sql = MySql::conectar()->prepare("DELETE FROM $tabela WHERE id = $id");
			}
			$sql->execute();
		}			

		//metodo especifico para selecionar apenas 1 registro da tabela 
		public static function selecionarTag($table,$query,$arr){
			$sql = MySql::conectar()->prepare("SELECT * FROM $table WHERE $query");
			$sql->execute($arr);
			return $sql->fetch();
		}		

	} 

?>