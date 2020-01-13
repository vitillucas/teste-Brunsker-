<?php
session_start();
ob_start();
$btnCadUsuario = filter_input(INPUT_POST, 'btnCadUsuario', FILTER_SANITIZE_STRING);
if($btnCadUsuario){
    include_once 'conexao.php';
    $dados_rc = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
    $erro = false;
    
    $dados_st = array_map('strip_tags', $dados_rc);
    $dados = array_map('trim', $dados_st);
    
    if(in_array('',$dados)){
        $erro = true;
        $_SESSION['msg'] = "Necessário preencher todos os campos";
    }elseif((strlen($dados['senha'])) < 6){
        $erro = true;
        $_SESSION['msg'] = "A senha deve ter no minímo 6 caracteres";
    }elseif(stristr($dados['senha'], "'")) {
        $erro = true;
        $_SESSION['msg'] = "Caracter ( ' ) utilizado na senha é inválido";
    }else{
        $result_usuario = "SELECT id FROM usuarios WHERE usuario='". $dados['usuario'] ."'";
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
            $erro = true;
            $_SESSION['msg'] = "Este usuário já está sendo utilizado";
        }
        
        $result_usuario = "SELECT id FROM usuarios WHERE email='". $dados['email'] ."'";
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
            $erro = true;
            $_SESSION['msg'] = "Este e-mail já está cadastrado";
        }
    }
    
    
    //var_dump($dados);
    if(!$erro){
        //var_dump($dados);
        $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
        $result_usuario = "INSERT INTO usuarios (nome, email, usuario, senha) VALUES (
                        '" .$dados['nome']. "',
                        '" .$dados['email']. "',
                        '" .$dados['usuario']. "',
                        '" .$dados['apelido']. "',
                        '" .$dados['cpf']. "',
                        '" .$dados['sexo']. "',
                        '" .$dados['data_nascimento']. "',
                        '" .$dados['estado']. "',
                        '" .$dados['cep']. "',
                        '" .$dados['telefone']. "',
                        '" .$dados['celular']. "',
                        '" .$dados['senha']. "'
                        )";
        $resultado_usario = mysqli_query($conn, $result_usuario);
        if(mysqli_insert_id($conn)){
            $_SESSION['msgcad'] = "Usuário cadastrado com sucesso";
            header("Location: login2.php");
        }else{
            $_SESSION['msg'] = "Erro ao cadastrar o usuário";
        }
    }
    
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bem-vindo a Makrochip - Login</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/signin.css" rel="stylesheet">
        
        <style>
        body{background: #eee url(http://subtlepatterns.com/patterns/sativa.png);}
html,body{
    position: relative;
    height: 100%;
}

.login-container{
    position: relative;
    width: 300px;
    margin: 80px auto;
    padding: 20px 40px 40px;
    text-align: center;
    background: #fff;
    border: 1px solid #ccc;
}

#output{
    position: absolute;
    width: 300px;
    top: -75px;
    left: 0;
    color: #fff;
}

#output.alert-success{
    background: rgb(25, 204, 25);
}

#output.alert-danger{
    background: rgb(228, 105, 105);
}


.login-container::before,.login-container::after{
    content: "";
    position: absolute;
    width: 100%;height: 100%;
    top: 3.5px;left: 0;
    background: #fff;
    z-index: -1;
    -webkit-transform: rotateZ(4deg);
    -moz-transform: rotateZ(4deg);
    -ms-transform: rotateZ(4deg);
    border: 1px solid #ccc;

}

.login-container::after{
    top: 5px;
    z-index: -2;
    -webkit-transform: rotateZ(-2deg);
     -moz-transform: rotateZ(-2deg);
      -ms-transform: rotateZ(-2deg);

}

.avatar{
    width: 100px;height: 100px;
    margin: 10px auto 30px;
    border-radius: 100%;
    border: 2px solid #aaa;
    background-size: cover;
    background-image: url("logo.jpg");
        
}

.form-box input{
    width: 100%;
    padding: 10px;
    text-align: center;
    height:40px;
    border: 1px solid #ccc;;
    background: #fafafa;
    transition:0.2s ease-in-out;

}

.form-box input:focus{
    outline: 0;
    background: #eee;
}

.form-box input[type="text"]{
    border-radius: 5px 5px 0 0;
    text-transform: lowercase;
}

.form-box input[type="password"]{
    border-radius: 0 0 5px 5px;
    border-top: 0;
}

.form-box button.login{
    margin-top:15px;
    padding: 10px 20px;
}

.animated {
  -webkit-animation-duration: 1s;
  animation-duration: 1s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}

@-webkit-keyframes fadeInUp {
  0% {
    opacity: 0;
    -webkit-transform: translateY(20px);
    transform: translateY(20px);
  }

  100% {
    opacity: 1;
    -webkit-transform: translateY(0);
    transform: translateY(0);
  }
}

@keyframes fadeInUp {
  0% {
    opacity: 0;
    -webkit-transform: translateY(20px);
    -ms-transform: translateY(20px);
    transform: translateY(20px);
  }

  100% {
    opacity: 1;
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    transform: translateY(0);
  }
}

.fadeInUp {
  -webkit-animation-name: fadeInUp;
  animation-name: fadeInUp;
}
</style>
    </head>
    <body>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<div class="container">
        <div class="login-container">
            <div id="output"></div>
            <div class="avatar"></div>
            <div class="form-box">
            <form method="POST" action="">
                    <label>Nome</label>
                    <input type="text" name="nome" placeholder="Digite o nome e o sobrenome" class="form-control"><br>
                    
                    <label>E-mail</label>
                    <input type="text" name="email" placeholder="Digite o seu e-mail" class="form-control"><br>
                    
                    <label>Usuário</label>
                    <input type="text" name="usuario" placeholder="Digite o usuário" class="form-control"><br>
                    
                    <label>Apelido</label>
                    <input type="text" name="apelido" placeholder="Digite a senha" class="form-control"><br>
                    
                    <label>CPF</label>
                    <input type="text" name="cpf" placeholder="Digite o cpf" class="form-control"><br>
                                       
                    <label>Sexo</label>
                    <input type="text" name="sexo" placeholder="Digite o sexo" class="form-control"><br>

                    <label>Data de Nascimento</label>
                    <input type="text" name="data_nascimento" placeholder="Digite a data de Nascimento" class="form-control"><br>

                    <label>Estado</label>
                    <input type="text" name="estado" placeholder="Digite o estado" class="form-control"><br>

                    <label>Cep</label>
                    <input type="text" name="cep" placeholder="Digite o cep" class="form-control"><br>

                    <label>telefone</label>
                    <input type="text" name="telefone" placeholder="Digite o telefone" class="form-control"><br>

                    <label>Celular</label>
                    <input type="text" name="celular" placeholder="Digite o celular" class="form-control"><br>
                   

                    <label>Senha</label>
                    <input type="password" name="senha" placeholder="Digite a senha" class="form-control"><br>
                   
                    <label>Cadastrar</label>
                    <input type="submit" name="btnCadUsuario" value="Cadastrar" class="btn-success"><br><br>
                    
                    <div class="row text-center" style="margin-top: 20px;"> 
                        Lembrou? <a href="login2.php">Clique aqui</a> para logar
               </form>
            </div>
        </div>
</div>
    </body>
    <script>
    $(function(){
var textfield = $("input[name=user]");
            $('button[type="submit"]').click(function(e) {
                e.preventDefault();
                //little validation just to check username
                if (textfield.val() != "") {
                    //$("body").scrollTo("#output");
                    $("#output").addClass("alert alert-success animated fadeInUp").html("Welcome back " + "<span style='text-transform:uppercase'>" + textfield.val() + "</span>");
                    $("#output").removeClass(' alert-danger');
                    $("input").css({
                    "height":"0",
                    "padding":"0",
                    "margin":"0",
                    "opacity":"0"
                    });
                    //change button text 
                    $('button[type="submit"]').html("continue")
                    .removeClass("btn-info")
                    .addClass("btn-default").click(function(){
                    $("input").css({
                    "height":"auto",
                    "padding":"10px",
                    "opacity":"1"
                    }).val("");
                    });
                    
                    //show avatar
                    $(".avatar").css({
                        background-image: url("https://i.pinimg.com/originals/b6/75/5f/b6755fc7178ad916c1aeb70ec1e54232.jpg");

                    });
                } else {
                    //remove success mesage replaced with error message
                    $("#output").removeClass(' alert alert-success');
                    $("#output").addClass("alert alert-danger animated fadeInUp").html("sorry enter a username ");
                }
                //console.log(textfield.val());

            });
});
</script>
</html>