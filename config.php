<?php 

    //configuracao do banco de dados      
    include('./class/mysql.php');   
	//configuracao do site
	include('./class/painel.php');  
	include('./class/categorias.php'); 
	include('./class/produtos.php'); 
	include('./class/tags.php'); 
	include('./class/usuarios.php'); 
	include('./class/produtos_tags.php'); 	
	

//	  //configuracao do relatorio PDF
//	  require_once './providers/dompdf/vendor/autoload.php';
//    require_once BASE_DIR_PATH.'/providers/dompdf/vendor/autoload.php';
//
//	  //referenciando o namespace da dompdf 
//	  use Dompdf\Dompdf;
//
//    //instancia DOMPDF
//    $dompdf = new Dompdf();
//
//    //carrega o html para dentro da classe
//    $dompdf->load_html('<b>Olá mundo</b>');
//
//	//define o tupi de folha de impressao
//	$dompdf->setPaper("A4", 'portrait');
//
//    //rederizar o arquivo PDF
//    $dompdf->render();
//
//    //imprimr conteudo do arquivo PDF na tela
//    header('Content-type: application/pdf');
//    echo $dompdf->output();
//
//	//imprime o arquivo no browse padrao
//	$dompdf->stream('relatorio.pdf', array('Attachment' => false));


	//trabalhando com sessao para armazenagem de dados  
	session_start(); 
	//trabalhando com data e hora de são paulo atual
	date_default_timezone_set('America/Sao_Paulo');      
    
    //define o caminho padrao do site para as contantes
    define('INCLUDE_PATH','http://localhost/PromobitProdutos/');
	define('INCLUDE_PATH_PAINEL',INCLUDE_PATH); 

	//define o caminho padrao do diretorio /INDEX no site
	define('BASE_DIR_PATH',__DIR__);

	//Conectar com banco de dados
	define('HOST','localhost');
	define('USER','root');
	define('PASSWORD','');
	define('DATABASE','promobitprodutos');	

	//variavel/contante da empresa desenvolvedora do site
	define('NOME_EMPRESA','PROMOBIT');

	//Funções do painel
	function selecionadoMenu($par){		
		$url = explode('/',@$_GET['url'])[0];
		if($url == $par){
			echo 'class="menu-active"';
		}
	}
    
	function verificaPermissaoMenu($permissao){

		if($_SESSION['id_perfil'] == '1'){
			if (mb_strpos('1 2', $permissao) !== false) {
				return;
			}else{
				echo 'style="display:none;"';
			}
		}else if($_SESSION['id_perfil'] == '2'){
			if (mb_strpos('2', $permissao) !== false) {
				return;
			}else{
				echo 'style="display:none;"';
			}
		}
	}


	function recoverPost($post){
		if(isset($_POST[$post])){
			echo $_POST[$post];
		}
	}

?> 