$(function(){

	var open  = true;
	var windowSize = $(window)[0].innerWidth;
	var targetSizeMenu = (windowSize <= 400) ? 200 : 250;

	// valida o tamanho da pagina
	window.addEventListener('resize', function() {
		if (window.matchMedia('(max-width: 750px)').matches) {
			targetSizeMenu = 200;
		}else {
			targetSizeMenu = 250;
		}
	}, true);  

	//valida menu vertical ao pressionar botao para minimizar ou maximizar 
	$('.menu-btn').click(function(){
		if(open){
			//O menu está aberto, precisamos fechar e adaptar nosso conteudo geral do painel
			$('.menu').animate({'width':0,'padding':0},function(){
				open = false;
			});
			$('.content,header').css('width','100%');
			$('.content,header').animate({'left':0},function(){
				open = false;
			});
		}else{
			//O menu está fechado
			$('.menu').css('display','block');
			$('.menu').animate({'width':targetSizeMenu+'px','padding':'10px 0'},function(){
				open = true;
			});
			if(windowSize > 768)
				$('.content,header').css('width','calc(100% - 250px)');
				$('.content,header').animate({'left':targetSizeMenu+'px'},function(){
				open = true;
			});
		}
	})

	//formata menu vertical ao minimizar ou maximizar apenas pelo tamanho da tela 
	$(window).resize(function(){

		var paginaAtual = document.getElementById("dia-de-inscricao").innerHTML;

		windowSize = $(window)[0].innerWidth;
		targetSizeMenu = (windowSize <= 400) ? 200 : 250;
		if(windowSize <= 750){
			$('.menu').css('width','0').css('padding','0');
			$('.content').css('width','100%').css('left','0');
			if(paginaAtual != '0'){
				$('header').css('width','100%').css('left','0');
			}
			open = false;
		}else{
			$('.menu').animate({'width':targetSizeMenu+'px','padding':'10px 0'},function(){
				open = true;
			});

			$('.content').css('width','calc(100% - 250px)');
			if(paginaAtual != '0'){
				$('header').css('width','calc(100% - 250px)');
			}
			$('.content').animate({'left':targetSizeMenu+'px'},function(){
				open = true;
			});
			if(paginaAtual != '0'){
				$('header').animate({'left':targetSizeMenu+'px'},function(){
					open = true;
				});
			}
		}

	})

	//formata campo data
	//$('[formato=data]').mask('99/99/9999');

	//valida acao do botao deletar 
	$('[actionBtn=delete]').click(function(){
		var txt;
		var r = confirm("Deseja excluir o registro?");
		if (r == true) {
			return true;
		} else {
			return false;
		}
	})	

	//valida acao do botao imprimir produto
	$('[actionBtn=imprimir]').click(function(){
		var txt;
		var r = confirm("Deseja imprimir este produto?");
		if (r == true) {
			return true;
		} else {
			return false;
		}
	})	


})