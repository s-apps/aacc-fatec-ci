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
            url: base_url+'admin/aluno/lista',
            type: 'GET',
            data:{busca:busca}
            }).done(function(data) {
                data = JSON.parse(data);
                $('#lista_tbody').html(data.html);
            });      
    });
    
    $('body').on('click','.btnGerarCertificado',function(){
        var $this = $(this);
        $this.button('loading');
        var id_atividade = $(this).data('id_atividade');
         $.ajax({
            url: base_url+'admin/certificado/gerar',
            type: 'GET',
            data:{id_atividade:id_atividade}
         }).done(function(data) {
                data = JSON.parse(data);
                $this.button('reset');
                if(data.sucesso){
                    window.open(data.certificado,'_blank');
                }else{
                    return false;
                }
        }); 
    });
    

   $('#id_curso').select2({
       language: "pt-BR",
       placeholder: "Selecione um Curso"
    });
});//document ready

