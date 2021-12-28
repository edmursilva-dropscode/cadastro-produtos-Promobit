<?php 
    //valida a configuracao de loggout    
	if(isset($_GET['loggout'])){
		Painel::loggout();
	}  
?>

<!DOCTYPE html>
<html lang="pt"> 

    <head> 

        <!--incorporando fontes do googlefonts-->      
        <!--font1-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">    
        <!--font2-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Passion+One:wght@700&display=swap" rel="stylesheet">

        <!-- Favicons -->
        <link href="<?php echo INCLUDE_PATH; ?>/img/icon-empresa.png" rel="icon">
        <link href="<?php echo INCLUDE_PATH; ?>/img/icon-empresa.png" rel="apple-touch-icon">

        <!--linkando o arquivo fornecedor externo CSS-->
        <link href="<?php echo INCLUDE_PATH; ?>/providers/fontawesome/css/all.css" rel="stylesheet" >
        <link href="<?php echo INCLUDE_PATH; ?>/providers/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo INCLUDE_PATH; ?>/providers/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

        <!--linkando o arquivo proprio interno CSS-->
        <link href="<?php echo INCLUDE_PATH_PAINEL; ?>css/style.css" rel="stylesheet">

        <!--formatoção de caracteres/acentuação utilizado no projeto-->
        <meta charset="utf-8">    
        <!--configuração para dispositivo movel-->  
        <meta name="viewport" content="width=device-width, initial-scale=1.0" name="viewport">
        <!--conteúdo resumido do projeto-->
        <meta name="description" content="conteúdo do meu projeto" name="description">
        <!--palavras do resumo para uma busca do projeto-->
        <meta name="keywords" content="palavras,separadas,por,virgula" name="keywords">
        <!--nome do autor ou empresa do projeto-->
        <meta name="author" content="DROPS.code - Edmur G Silva Jr">    
        <!--título do projeto-->
        <title>PROMOBIT Produtos</title>       

    </head>  

    <body onload="javascript:autoRefresh();">

        <div class="campo-id-marcacao">
            <div id="pagina-atual">1</div><!--dia-de-inscricao-->
        </div><!--campo-id-marcacao-->  

        <!--codigo do projeto(parte01)--> 
        <section id="painel" class="painel">

            <div class="menu">
                <div class="menu-wraper">
                    <div class="box-usuario">

                        <div class="imagem-logo">
                            <img src="<?php echo INCLUDE_PATH_PAINEL ?>img/icon-empresa1.png" />
                        </div><!--imagem-logo-->  

                        <?php
                            if($_SESSION['img'] == ''){
                        ?>
                            <div class="avatar-usuario">
                                <i class="bi bi-person-fill"></i>
                            </div><!--avatar-usuario-->   
                        <?php }else{ ?>
                            <div class="imagem-usuario">
                                <img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/user/<?php echo $_SESSION['img']; ?>" />
                            </div><!--imagem-usuario-->     
                        <?php } ?>                              
                        <div class="nome-usuario">
                            <p><?php echo $_SESSION['nome']; ?></p>
                            <?php $descricaoPerfil = Painel::select('tb_site_perfis','id=?',array($_SESSION['id_perfil']))['descricao']; ?>
                            <p><?php echo $descricaoPerfil; ?></p> 
                        </div><!--nome-usuario-->                         
                    </div>   

                    <div id="fundo-itens-menu">
                        <div id="items-menu">
                            <a <?php verificaPermissaoMenu(1); ?> <?php selecionadoMenu('usuarios'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>usuarios"><i class="bi bi-people-fill"></i>  Usuários</a>
                            <a <?php verificaPermissaoMenu(1); ?> <?php selecionadoMenu('listar-usuarios'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-usuarios"><i class="bi bi-people-fill"></i>  Listar usuários</a>
                            <a <?php verificaPermissaoMenu(2); ?> <?php selecionadoMenu('categorias'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>categorias"><i class="bi bi-ui-checks"></i>  Categorias</a>
                            <a <?php verificaPermissaoMenu(2); ?> <?php selecionadoMenu('listar-categorias'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-categorias"><i class="bi bi-ui-checks"></i>  Listar categorias</a>
                            <a <?php verificaPermissaoMenu(2); ?> <?php selecionadoMenu('tags'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>tags"><i class="bi bi-tags-fill"></i>  Tags</a>
                            <a <?php verificaPermissaoMenu(2); ?> <?php selecionadoMenu('listar-tags'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-tags"><i class="bi bi-tags-fill"></i>  Listar tags</a>                        
                            <a <?php verificaPermissaoMenu(2); ?> <?php selecionadoMenu('produtos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>produtos"><i class="bi bi-inboxes-fill"></i>  Produtos</a>
                            <a <?php verificaPermissaoMenu(2); ?> <?php selecionadoMenu('listar-produtos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-produtos"><i class="bi bi-inboxes-fill"></i>  Listar produtos</a>                        
                        </div><!--items-menu-->  
                    </div>

                </div>
            </div><!--menu-->

            <header>
                <div class="center">

                    <div class="menu-btn">
                        <i class="bi bi-list"></i>
                    </div><!--menu-btn-->

                    <div class="loggout">                        
                        <a <?php if(@$_GET['url'] == ''){ ?> style="background: #0da6a6;color: white;padding: 20px;" <?php } ?> href="<?php echo INCLUDE_PATH_PAINEL ?>"> <i class="bi bi-house-fill"></i> <span>Página Inicial</span></a>
                        <a href="<?php echo INCLUDE_PATH_PAINEL ?>?loggout"> <i class="bi bi-box-arrow-right"></i> <span>Sair</span></a>
                    </div><!--loggout-->

                    <div class="clear"></div><!--limpa flutuações-->
                </div>
            </header><!--header-->

            <div class="content">

                <!--carrega pagina do painel de controle-->
                <?php Painel::carregarPagina(); ?>

            </div><!--content-->             

        </section><!--painel-->

        <!--linkando o arquivo fornecedor externo JS-->
        <script src="<?php echo INCLUDE_PATH; ?>/providers/bootstrap/js/bootstrap.bundle.min.js"></script> 
        <script src="<?php echo INCLUDE_PATH; ?>/providers/jquery-v3.6.0/jquery.js"></script>  

        <!--linkando o arquivo proprio interno JS-->
        <script src="<?php echo INCLUDE_PATH; ?>/js/jquery-mask.js"></script> <!--esta biblioteca depende do JQUERY.JS por isto tem que ser declarada depois-->
        <script src="<?php echo INCLUDE_PATH; ?>/js/main.js"></script>         

        <!--configura funcoes que executa na pagina-->
        <script>  

            // configura menu vertical conforme tamanho de pagina
            window.addEventListener('resize', function() {      
                if (window.matchMedia('(max-width: 750px)').matches) {
                    $('.imagem-logo').css('width','180px');
                    $('.imagem-logo').css('height','60px');
                    $('.menu').css('width','200px');
                    $('.menu').css('padding','10px 0');
                    $('.menu-wraper').css('width','200px');
                    $('header').css('left','200px');
                    $('header').css('width','calc(100% - 200px)');    
                    $('.content').css('left','200px');
                    $('.content').css('width','calc(100% - 200px)');                                      
                }else {
                    $('.imagem-logo').css('width','200px');
                    $('.imagem-logo').css('height','70px');
                    $('.menu').css('width','250px');
                    $('.menu').css('padding','10px 0');
                    $('.menu-wraper').css('width','250px');
                    $('header').css('left','250px');  
                    $('header').css('width','calc(100% - 250px)');                                      
                    $('.content').css('left','250px');
                    $('.content').css('width','calc(100% - 250px)');                      
                }
            }, true);  

            // configura menu vertical quando dar REFRESH na pagina
            function autoRefresh() {
                if (window.matchMedia('(max-width: 750px)').matches) {
                    $('.imagem-logo').css('width','180px');
                    $('.imagem-logo').css('height','60px');
                    $('.menu').css('width','200px');
                    $('.menu').css('padding','10px 0');
                    $('.menu-wraper').css('width','200px');
                    $('header').css('left','200px');
                    $('header').css('width','calc(100% - 200px)');    
                    $('.content').css('left','200px');
                    $('.content').css('width','calc(100% - 200px)');                                      
                }else {
                    $('.imagem-logo').css('width','200px');
                    $('.imagem-logo').css('height','70px');
                    $('.menu').css('width','250px');
                    $('.menu').css('padding','10px 0');
                    $('.menu-wraper').css('width','250px');
                    $('header').css('left','250px');  
                    $('header').css('width','calc(100% - 250px)');                                      
                    $('.content').css('left','250px');
                    $('.content').css('width','calc(100% - 250px)');                      
                }            
            }     

            //configura uma previa atualizada da imagem do usuario do site 
            var imagemEntradaUsuario = $("#imagemUsuario");    
            imagemEntradaUsuario.on("change", function () {
                //console.log($(this));                
                const file = $(this)[0].files[0]
                const fileReader = new FileReader()
                fileReader.onloadend = function(){
                    $('#imagem-upload-usuario').attr('src',fileReader.result)
                }
                fileReader.readAsDataURL(file)
            }); 

            //configura uma previa atualizada da imagem do usuario do site
            var imagemEntradaUsuarioAtualizada = $("#imagemAtualizada");    
            imagemEntradaUsuarioAtualizada.on("change", function () {
                //console.log($(this));                
                const file = $(this)[0].files[0]
                const fileReader = new FileReader()
                fileReader.onloadend = function(){
                    $('#imagem-upload-usuario').attr('src',fileReader.result)
                }
                fileReader.readAsDataURL(file)
            });             
            
            //configura uma previa atualizada da imagem do produto do site 
            var imagemEntradaProduto = $("#imagemProduto");    
            imagemEntradaProduto.on("change", function () {
                //console.log($(this));                
                const file = $(this)[0].files[0]
                const fileReader = new FileReader()
                fileReader.onloadend = function(){
                    $('#imagem-upload-produto').attr('src',fileReader.result)
                }
                fileReader.readAsDataURL(file)
            }); 

            //configura uma previa atualizada da imagem do produto do site
            var imagemEntradaProdutoAtualizada = $("#imagemAtualizada");    
            imagemEntradaProdutoAtualizada.on("change", function () {
                //console.log($(this));                
                const file = $(this)[0].files[0]
                const fileReader = new FileReader()
                fileReader.onloadend = function(){
                    $('#imagem-upload-produto').attr('src',fileReader.result)
                }
                fileReader.readAsDataURL(file)
            });             

            //redefine altura da funcao fundo-itens-menu
            var altura_itemsmenu = document.getElementById("items-menu").offsetHeight;            
            document.getElementById('fundo-itens-menu').style.height = altura_itemsmenu + "px";

        </script>             

    </body>
</html>