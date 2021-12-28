<?php
	
    //configuracao geral      
	include('./config.php'); 	 
 
    //valida login 
	if(Painel::logado() == false){
		include('login.php');
	}else{
		include('main.php');
	}      

?>  