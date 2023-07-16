<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP4Y</title>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
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

        function inserir(){
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
                if(validarCPF(txtCPF) == false){
                    alert('CPF inválido!');
                }
                else if(validarEmail(txtEmail) == false){
                    alert('E-mail inválido!');
                }
                else{
                    $.ajax({
                        url: 'http://127.0.0.1:8000/api/customers/new',
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
                            alert("Cadastrado com sucesso!");
                        },
                        error: function (xhr, err) {
                            if(xhr.status == 403){
                                console.log(err);
                                alert("CPF já cadastrado!");
                            }
                            else{
                                console.log(err);
                                alert("Erro ao cadastrar!");
                            }
                        },
                    });
                }
            }
            
        }
        
    </script>
</head>
<body class="main">
    <h2>Cadastro</h2>
    <br>
    <div>
        <form>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="txtCPF">CPF</label>
                    <input type="text" class="form-control" id="txtCPF" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"><br>
                </div>
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
        </form>
        <br><br><button id="btnResetar" class="btn btn-primary" onClick="window.location.reload();" style="position: absolute; left: 0; margin-left: 40px; ">Recomeçar</button>&nbsp;
        <button id="btnInserir" style="background-color: rgb(107, 177, 0); border-color: transparent; right: 0; position: absolute; margin-right: 40px;" class="btn btn-primary">Inserir</button>
        <a href='http://127.0.0.1:8000/search'><button type="button" class="btn btn-primary" style="margin-right: 40px; margin-top: 40px; right: 0; top: 0; position: absolute;">Listar</button></a>
    </div>
        <script>
            var btnInserir = document.getElementById("btnInserir");
            btnInserir.addEventListener("click", function(event){
                inserir();
            })
        </script>
</body>
</html>