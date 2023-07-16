<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <script>
        function procurar(){
            var txtCPF = document.getElementById("txtCPF").value;
            var txtNome = document.getElementById("txtNome");
            var txtSobrenome = document.getElementById("txtSobrenome");
            var txtDataNasc = document.getElementById("txtDataNasc");
            var txtEmail = document.getElementById("txtEmail");
            var txtGenero = document.getElementById("txtGenero");

            $.ajax({
                url: 'http://127.0.0.1:8000/api/customers/find',
                type: 'POST',
                data: {
                    CPF: txtCPF
                },
				dataType: 'json',
                success: function(data) {
                    console.log(data);
                    txtNome.value = data[0].nome;
                    txtSobrenome.value = data[0].sobrenome;
                    txtDataNasc.value = data[0].dataNasc;
                    txtEmail.value = data[0].email;
                    txtGenero.value = data[0].genero;
				},
				error: function(err) {
					console.log(err.responseText.message);
				}
			});
        }

        function validarCPF(strCpf){	
            if (strCpf.length != 11 || 
                strCpf == "00000000000" || 
                strCpf == "11111111111" || 
                strCpf == "22222222222" || 
                strCpf == "33333333333" || 
                strCpf == "44444444444" || 
                strCpf == "55555555555" || 
                strCpf == "66666666666" || 
                strCpf == "77777777777" || 
                strCpf == "88888888888" || 
                strCpf == "99999999999"){
                return false;
            }
            var soma = 0;

            for(var i = 1; i <= 9; i++){
                soma += parseInt(strCpf.substring(i - 1, i)) * (11 - i);
            }

            var resto = soma % 11;

            if(resto === 10 || resto === 11 || resto < 2){
                resto = 0;
            }
            else{
                resto = 11 - resto;
            }

            if(resto !== parseInt(strCpf.substring(9, 10))){
                return false;
            }

            soma = 0;

            for(var i = 1; i <= 10; i++){
                soma += parseInt(strCpf.substring(i - 1, i)) * (12 - i);
            }
            resto = soma % 11;

            if(resto === 10 || resto === 11 || resto < 2){
                resto = 0;
            }
            else{
                resto = 11 - resto;
            }
        
            if(resto !== parseInt(strCpf.substring(10, 11))){
                return false;
            }

            return true; 
        }

        function validarEmail(strEmail) {
            var usuario = strEmail.substring(0, strEmail.indexOf("@"));
            var dominio = strEmail.substring(strEmail.indexOf("@")+ 1, strEmail.length);

            if ((usuario.length >=1) &&
                (dominio.length >=3) &&
                (usuario.search("@")==-1) &&
                (dominio.search("@")==-1) &&
                (usuario.search(" ")==-1) &&
                (dominio.search(" ")==-1) &&
                (dominio.search(".")!=-1) &&
                (dominio.indexOf(".") >=1)&&
                (dominio.lastIndexOf(".") < dominio.length - 1)) {
                return true;
            }
            else{
                return false;
            }
        }

        function alterar(){
            var txtCPF = document.getElementById("txtCPF").value;
            var txtNome = document.getElementById("txtNome").value;
            var txtSobrenome = document.getElementById("txtSobrenome").value;
            var txtDataNasc = document.getElementById("txtDataNasc").value;
            var txtEmail = document.getElementById("txtEmail").value;
            var txtGenero = document.getElementById("txtGenero").value;

            if(txtCPF == '' || txtNome == '' || txtSobrenome == '' || txtDataNasc == '' || txtEmail == '' || txtGenero == ''){
                alert("Preencha todos os campos!")
            }
            else{
                if(validarEmail(txtEmail) == false){
                    alert('E-mail inválido!');
                }
                else{
                    $.ajax({
                        url: 'http://127.0.0.1:8000/api/customers/update',
                        type: 'POST',
                        data: {
                            CPF: txtCPF,
                            nome: txtNome,
                            sobrenome: txtSobrenome,
                            dataNasc: txtDataNasc,
                            email: txtEmail,
                            genero: txtGenero
                        },
                        dataType: 'json',
                        success: function(data){
                            console.log(data);
                            alert("Alterado com sucesso!");
                        },
                        error: function (err) {
                            console.log(err.responseText.message);
                            alert("Erro ao alterar!");
                        },
                    });
                }
            }
            
        }

        function excluir(){
            var txtCPF = document.getElementById("txtCPF").value;
            $.ajax({
                url: 'http://127.0.0.1:8000/api/customers/delete',
                type: 'DELETE',
                data: {
                    CPF: txtCPF
                },
				dataType: 'json',
                success: function() {
                    alert("Excluído com sucesso!");
				},
				error: function(err) {
					console.log(err);
				}
			});
        }
    </script>
</head>
<body class='main'>
    <h2>Alteração</h2>
    <label for="txtCPF">CPF</label>
    <input type="text" class="form-control" id="txtCPF">
    <button class="procurar" onclick="procurar();">Procurar</button>
    <form>
        <br>
        <div class="form-group col-md-6">
            <label for="txtNome">Nome</label>
            <input type="text" class="form-control" id="txtNome"><br>
        </div>
        <div class="form-group col-md-6">
            <label for="txtSobrenome">Sobrenome</label>
            <input type="text" class="form-control" id="txtSobrenome"><br>
        </div>
        <div class="form-group col-md-6">
            <label for="txtDataNasc">Data de nascimento</label>
            <input type="date" class="form-control" id="txtDataNasc"><br>
        </div>
        <div class="form-group col-md-6">
            <label for="txtEmail">E-mail</label>
            <input type="text" class="form-control" id="txtEmail"><br>
        </div>
            <label for="txtGenero">Gênero</label>
            <select class="form-select" aria-label="Disabled select example" id="txtGenero" style="width: 15%;">
                <option style="display:none"></option>
                <option value="Feminino">Feminino</option>
                <option value="Masculino">Masculino</option>
            </select>
        </div>
        <br><br><a href='http://127.0.0.1:8000/search'><button type="button" id="btnVoltar" class="btn btn-primary">Voltar</button></a>&nbsp;
        <button id="btnExcluir" style="background-color: red; border-color: transparent;" class="btn btn-primary" onclick="excluir()">Excluir</button>&nbsp;
        <button id="btnAlterar" style="background-color: rgb(107, 177, 0); border-color: transparent;" class="btn btn-primary" onclick="alterar();">Alterar</button>
        
    </form>
    
</body>
</html>