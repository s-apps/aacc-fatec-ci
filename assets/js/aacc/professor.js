var base_url = 'https://aacc.silverio.eti.br/';

$(document).ready(function() {
    $('#buscar').on('keyup',function(){
        var busca = $(this).val();
        if(busca.lenght===0){
            $('.box-footer').show();
        }else{
            $('.box-footer').hide();
        }
        $.ajax({
            url: base_url+'admin/professor/lista',
            type: 'GET',
            data:{busca:busca}
            }).done(function(data) {
                data = JSON.parse(data);
                $('#lista_tbody').html(data.html);
            });      
    });
});//document ready

