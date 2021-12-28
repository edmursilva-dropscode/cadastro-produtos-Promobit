<?php
	class MySql{

		private static $pdo;
        //conecta ao banco de dados DEVIORESTAURANTE  
		public static function conectar(){
			if(self::$pdo == null){
				try{
				self::$pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE,USER,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				}catch(Exception $e){
					echo '<h2>Erro ao conectar</h2>';
				}
			}
			return self::$pdo;
		}

		//desconecta ao banco de dados DEVIORESTAURANTE
		public static function desconectar(){
			//valida se existe uma sessao
			if(isset($_SESSION['login'])){
				//destroi todas os dados das sessoes
				session_destroy();
			}
		}		

	}
?>