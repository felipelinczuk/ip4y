<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <script>
        function load(){
            $.ajax({
                url: 'http://127.0.0.1:8000/api/customers',
                type: 'GET',
				dataType: 'json',
                success: function(data) {
					var table = "<thead><tr class='head'><th>CPF</th><th>Nome</th><th>Sobrenome</th><th>Data de nascimento</th><th>E-mail</th><th>Gênero</th></tr></thead>";
					for(var i = 0; i < data.length; i++) {
                        
                        table += `<tr style='border: 1px lightgray solid;'><th>${data[i].CPF}</th><th>${data[i].nome}</th><th>${data[i].sobrenome}</th><th>${data[i].dataNasc}</th><th>${data[i].email}</th><th>${data[i].genero}</th></tr>`
					}
                    table += '</tbody>'				
					document.getElementById("tabela").innerHTML = table;

				},
				error: function(err) {
					console.log(err.responseText.message);
				}
			});
        }

        function exportData(){
            $.ajax({
                url: 'http://127.0.0.1:8000/api/send',
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    alert('Dados enviados para Ip4y!');
                },
                error: function(err, data){
                    console.log(err, data);
                }
            });
        }

    </script>
</head>
<body class="main" onload="load();">
    <div class="tabela">
        <table id="tabela">
            <tr style="height: 100%;"><td class="col">Não há dados</td></tr>
        </table>
    </div>
    <a href='http://127.0.0.1:8000/edit'><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAlt" style="margin-bottom: 40px; margin-right: 40px; bottom: 0; right: 0; position: absolute; background-color: orange; border-color: transparent;">Alterar</button></a>
    <div style="text-align: center;">
        <button class="exportar" type="button" onclick="exportData();">Exportar dados(Ip4y)</button></a>
    </div>
    <a href='http://127.0.0.1:8000/'><button type="button" class="btn btn-primary" style="margin-bottom: 40px; margin-left: 40px; bottom: 0; left: 0; position: absolute;">Cadastrar</button></a>
</body>
</html>