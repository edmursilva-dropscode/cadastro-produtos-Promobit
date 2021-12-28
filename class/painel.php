<?php
	
	class Painel 
	{
			
        //valida se o usuario esta logado ou não  
		public static function logado(){
            //valida se existe sessao login
			return isset($_SESSION['login']) ? true : false;
		}
		
		//valida se o usuario fez loggout ou não
		public static function loggout(){
			setcookie('lembrar','true',time()-1,'/');
			//destroi todas os dados das sessoes
			session_destroy();
			//define o caminho padrao do site para as contantes para o usuario fazer login novamente
			header('Location: '.INCLUDE_PATH_PAINEL);
		}

		//carrega paginas do painel de controle 
		public static function carregarPagina(){
			//valida se existe URL
			if(isset($_GET['url'])){
				//recebe URL na variavel
				$url = explode('/',$_GET['url']);
				//valida se existe pagina/arquivo .PHP
				if(file_exists('pages/'.$url[0].'.php')){
					include('pages/'.$url[0].'.php');
				}else{
					//pagina/arquivo .PHP não existe!
					header('Location: '.INCLUDE_PATH_PAINEL);
				}
			}else{
				//pagina/arquivo .PHP não existe, exibe HOME.PHP
				include('pages/home.php');
			}
		}			

		//alerta se processo foi efetuado ou nao
		public static function alert($tipo,$mensagem){
			if($tipo == 'sucesso'){
				echo '<div class="box-alert sucesso"><i class="bi bi-check"></i> '.$mensagem.'</div>';
			}else if($tipo == 'erro'){
				echo '<div class="box-alert erro"><i class="bi bi-x"></i> '.$mensagem.'</div>';
			}
		}

		//lista todos os registros de uma tabela ou todos os registros com limite de apresentacao pelo campo ID
		public static function selectAll($tabela,$start = null,$end = null){
			if($start == null && $end == null){
				$sql = MySql::conectar()->prepare("SELECT * FROM $tabela ORDER BY id");
			}else{
				$sql = MySql::conectar()->prepare("SELECT * FROM $tabela ORDER BY id LIMIT $start,$end");
			}
			$sql->execute();
			//
			return $sql->fetchAll();

		}		

		//lista todos os registros de uma tabela ou todos os registros com limite de apresentacao pelo campo ORDER_ID
		public static function  selectAllOrderId($tabela,$start = null,$end = null){
			if($start == null && $end == null){
				$sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY order_id ASC");
			}else{
				$sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY order_id ASC LIMIT $start,$end");
			}
			$sql->execute();			
			return $sql->fetchAll();

		}		

		//redireciona a url
		public static function redirect($url){
			echo '<script>location.href="'.$url.'"</script>';
			//matar/fechar o comando redirecionamento
			die();
		}	

		//seleciona apenas 1 registro da tabela 
		public static function select($table,$query = '',$arr = ''){
			if($query != false){
				$sql = MySql::conectar()->prepare("SELECT * FROM `$table` WHERE $query");
				$sql->execute($arr);
			}else{
				$sql = MySql::conectar()->prepare("SELECT * FROM `$table`");
				$sql->execute();
			}
			return $sql->fetch();
		}

		//atualiza o registro do metodo ORDERITEM no campo ORDER_ID
		public static function update($arr,$single = false){
			$certo = true;
			$first = false;
			$nome_tabela = $arr['nome_tabela'];

			$query = "UPDATE `$nome_tabela` SET ";
			foreach ($arr as $key => $value) {
				$nome = $key;
				$valor = $value;
				if($nome == 'acao' || $nome == 'nome_tabela' || $nome == 'id')
					continue;
				if($value == ''){
					$certo = false;
					break;
				}
				
				if($first == false){
					$first = true;
					$query.="$nome=?";
				}
				else{
					$query.=",$nome=?";
				}

				$parametros[] = $value;
			}

			if($certo == true){
				if($single == false){
					$parametros[] = $arr['id'];
					$sql = MySql::conectar()->prepare($query.' WHERE id=?');
					$sql->execute($parametros); 
				}else{
					$sql = MySql::conectar()->prepare($query);
					$sql->execute($parametros);
				}
			}
			return $certo;
		}

		//ordena o registro para cima ou para baixo conforme campo ORDER_ID de cada tabela
		public static function orderItem($tabela,$orderType,$idItem){
			if($orderType == 'up'){
				$infoItemAtual = Painel::select($tabela,'id=?',array($idItem));
				$order_id = $infoItemAtual['order_id'];
				$itemBefore = MySql::conectar()->prepare("SELECT * FROM `$tabela` WHERE order_id < $order_id ORDER BY order_id DESC LIMIT 1");
				$itemBefore->execute();
				if($itemBefore->rowCount() == 0)
					return;
				$itemBefore = $itemBefore->fetch();
				Painel::update(array('nome_tabela'=>$tabela,'id'=>$itemBefore['id'],'order_id'=>$infoItemAtual['order_id']));
				Painel::update(array('nome_tabela'=>$tabela,'id'=>$infoItemAtual['id'],'order_id'=>$itemBefore['order_id']));
			}else if($orderType == 'down'){
				$infoItemAtual = Painel::select($tabela,'id=?',array($idItem));
				$order_id = $infoItemAtual['order_id'];
				$itemBefore = MySql::conectar()->prepare("SELECT * FROM `$tabela` WHERE order_id > $order_id ORDER BY order_id ASC LIMIT 1");
				$itemBefore->execute();
				if($itemBefore->rowCount() == 0)
					return;
				$itemBefore = $itemBefore->fetch();
				Painel::update(array('nome_tabela'=>$tabela,'id'=>$itemBefore['id'],'order_id'=>$infoItemAtual['order_id']));
				Painel::update(array('nome_tabela'=>$tabela,'id'=>$infoItemAtual['id'],'order_id'=>$itemBefore['order_id']));
			}
		}		

	}

?>