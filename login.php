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
        <link href="<?php echo INCLUDE_PATH_PAINEL; ?>/css/style.css" rel="stylesheet">

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

    <body>  

        <div class="campo-id-marcacao">
            <div id="pagina-atual">0</div><!--dia-de-inscricao-->
        </div><!--campo-id-marcacao-->   

        <!--codigo do projeto(parte01)--> 
        <header id="header">                  

            <div class="header-menu">

                <h1 class="logo me-auto"><a href="index.html">Cadastro de produtos</a></h1>            

                <nav class="navbar">
                    <ul>
                        <li><a class="signin" onclick="exibeBoxLogin();">Login</a></li>  
                    </ul>
                </nav><!--desktop-menu-->                                  

                <div class="clear"></div><!--clear(reset para flutuação)-->

            </div><!--header-menu-->                                  

            <div class="sucesso-erro-box erro"> <i class="bi bi-x"></i> Usuario ou Senha incorretos, favor tentar novamente!!! </div>          

        </header><!--header-->

        <!--codigo do projeto(parte02)-->
        <section id="login" class="login">



            <!-- valida envio do formulario login -->
            <?php
                //verifica se existe o metodo ACAO, para enviar o formulario login
                if(isset($_POST['acao'])){

                    //variaveis de controle
                    $user = $_POST['user'];
                    $password = $_POST['password'];


                    $sql = MySql::conectar()->prepare("SELECT * FROM tb_admin_usuarios WHERE usuario = ? AND senha = ?");
                    $sql->execute(array($user,$password));
                    if($sql->rowCount() == 1){
                        $info = $sql->fetch();
                        //Logamos com sucesso.
                        $_SESSION['login'] = true;
                        $_SESSION['usuaio'] = $user;
                        $_SESSION['senha'] = $password;
                        $_SESSION['id_perfil'] = $info['id_perfil'];
                        $_SESSION['nome'] = $info['nome']; 
                        $_SESSION['img'] = $info['img'];
                        $_SESSION['id_Usuario'] = $info['id'];
                        //
                        header('Location: '.INCLUDE_PATH_PAINEL);
                        //
                        die();                    
                    }else{
                        //Falhou
                        echo '<style>.sucesso-erro-box { display: block; }</style>';
                        echo "<meta HTTP-EQUIV='refresh' CONTENT='4'>";
                    }
                } 
            ?>      

            <div class="container">  

                <div id="box-login">

                    <div class="section-title">
                        <h2>Efetue o login</h2>
                    </div>                    

                    <div class="row justify-content-center">             

                        <div class="php-login-form">

                            <div class="row">
                            
                                <!--valida e configura do seu formulario para o login-->
                                <form id="formFormularioLogin" method="post">
                                    <div class="form-group mt-3">
                                            <input type="text" name="user" class="form-control" id="user" placeholder="Usuário" required>
                                    </div>                            
                                    <div class="form-group mt-3">
                                        <input type="password" name="password" class="form-control" id="password" placeholder="Senha" required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <div class="text-center">     
                                            <input type="hidden" name="identificador" value="form_login">           <!--campos ocultos para servir de referencia-->
                                            <input type="submit" name="acao" value="Login">
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </section><!-- End login Section -->

        <!--linkando o arquivo fornecedor externo JS-->
        <script src="<?php echo INCLUDE_PATH; ?>/providers/bootstrap/js/bootstrap.bundle.min.js"></script> 
        <script src="<?php echo INCLUDE_PATH; ?>/providers/jquery-v3.6.0/jquery.js"></script>  

        <!--linkando o arquivo proprio interno JS-->
        <script src="<?php echo INCLUDE_PATH; ?>/js/jquery-mask.js"></script> <!--esta biblioteca depende do JQUERY.JS por isto tem que ser declarada depois-->
        <script src="<?php echo INCLUDE_PATH; ?>/js/main.js"></script>   
        
        <!--configura funcoes que executa na pagina-->
        <script>    
            //configura a exibircao do box login
            function exibeBoxLogin(){

                if($('#box-login').css('display') == 'none'){
                    document.getElementById('box-login').style.display = 'block'; 
                }else{
                    document.getElementById('box-login').style.display = 'none'; 
                }
                  
            }   

        </script>   

    </body>

</html>