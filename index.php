<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procurando a palavra</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .d-none{
            display: none !important;
        }
        .modal-versiculos{
            position: fixed;
            width: 100%;
            height: 100vh;
            background-color: #2d4859;
        }
        .wraper-versiculos, .wraper-info{
            padding: 17px;
        }
        .close{
            color: white;
            font-size: 40px;
            width: 40px;
            height: 40px;
            display: flex;
            position: absolute;
            left: 88%;
            cursor: pointer;
            line-height: 40px;
        }
        .wraper-info{
            line-height: 7px;
            height: 10vh;
        }
        /* Largura da barra de rolagem */
        ::-webkit-scrollbar {
            width: 4px;
        }

        /* Fundo da barra de rolagem */
        ::-webkit-scrollbar-track-piece {
            background-color: #2d4859;
            border-left: 1px solid #2d4859
        }

        /* Cor do indicador de rolagem */
        ::-webkit-scrollbar-thumb:vertical,
        ::-webkit-scrollbar-thumb:horizontal {
            background-color: #ffeb00
        }

        /* Cor do indicador de rolagem - ao passar o mouse */
        ::-webkit-scrollbar-thumb:vertical:hover,
        ::-webkit-scrollbar-thumb:horizontal:hover {
            background-color: #ffeb00
        }
        .wraper-versiculos{
            overflow-x: scroll;
            height: 90vh;
        }
        .margin-modal{
            margin: 0 auto;
            max-width: 800px;
        }
        .logo{
            text-align: center;
            color: white;
            font-family: 'Poppins', sans-serif;
        }
        .buscador{
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        p{
            color: white;
            font-family: 'Poppins', sans-serif;
        }
        body{
            background-color: #2D4859;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100vh;
            padding: 0;
            margin: 0;
        }
        button{
            height: 45px;
            border: 0;
            font-size: 14px;
            width: 95px;
            margin-left: -52px;
            cursor: pointer;
            text-transform: uppercase;
            color: #2d4859;display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffeb00;
            font-weight: bolder;
            border-radius: 36px;
        }
        input{ 
            border: 0;
            width: 425px;
            height: 44px;
            padding: 4px 4px 4px 22px;
            border-radius: 28px;
        }
        .modal-versiculos{
            position: fixed;
        }
    </style>
</head>


<body>

<div class="black-vel d-none" style="width: 100%;background-color: #2d4859ed;height: 100vh;position: fixed;display: flex;justify-content: center;align-items: center;">
<h2 style="color: white;text-transform: uppercase;font-family: 'Poppins';text-align: center;">Procurando nos registros</h2>
</div>

    <div class="modal-versiculos d-none">
        <div class="margin-modal">
        <div class="close">&larr;</div>
        <div class="wraper-info">
        <p>Encontrados: <a class="accurrence"></a></p>
        <p>Versão: <a class="version" style="text-transform: uppercase;"></a></p>
        </div>
        <div class="wraper-versiculos">
   
        </div>
        </div>
    </div>


    <h1 class="logo"> Biblia.Help </h1>
    

    <div class="buscador">
        <input type="text" name="palavra" placeholder="Digite sua palavra" id="palavra">
        <button id="buscar">Buscar</button>
    </div>

    <p style="text-align: center;">&lt; Criado com muito <b style="color:red;">&#10084</b> por <a style="color: #fee73a;text-decoration: none;" href="https://github.com/Peralta0411">João V. M. G. Santos</a> /&gt;</p>

</body>

<!–JQUERY–>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<!–SCRIPT DE REQUEST API DA BIBLIA–>
<script>
$( document ).ready(function() {
    $('.close').click(function(){
        $('.modal-versiculos').addClass('d-none')
    })


    $('#buscar').click(function(){
        var palavra = $('#palavra').val();
        var SendInfo = {version:"nvi",search:palavra}
        $.ajax({
        method: "POST",
        dataType : "json",
        url: "https://www.abibliadigital.com.br/api/verses/search",
        data: JSON.stringify(SendInfo),
        contentType: "application/json; charset=utf-8",
        beforeSend:function(xhr){
            xhr.setRequestHeader('Authorization', 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IlN1biBKYW4gMTYgMjAyMiAwNjo0NzozNiBHTVQrMDAwMC52aWN0b3ItMDQxMTFAaG90bWFpbC5jb20iLCJpYXQiOjE2NDIzMTU2NTZ9.06KjXk87RO8nvJ5VIEgzerIdXVwzMEidY8dvbvLPm54');
            $('.black-vel').removeClass('d-none');
        },
        
        success: function(data){
            $('.black-vel').addClass('d-none');
            $( ".wraper-versiculos").empty();
            $('.modal-versiculos').removeClass('d-none')
            $('.accurrence').text(data.occurrence)
            $('.version').text(data.version)
            console.log(data)
            $.each(data.verses, function( index, value ) {
                $( ".wraper-versiculos" ).append('<div class="versiculo-single"><p>'+value.text+' - '+value.book.name+' <b>'+value.chapter+':'+value.number+'</b><p/></div>');
            });
        }
        })


    })
});
</script>


</html>


