var base_url = 'https://aacc.silverio.eti.br/';

$(document).ready(function() {
    $('body').on('submit','#frmHorasRealizadasAluno',function(){
        $('#resultado').html('');
        var $this = $('#btnRelatorio');
        $this.button('loading');
        var ra_aluno = $('#ra_aluno').val();
        $.ajax({
            url: base_url+'admin/relatorio/get_horas_realizadas_aluno',
            type: 'POST',
            data: {ra_aluno:ra_aluno}
            }).done(function(data) {
                data = JSON.parse(data);
                if(data.sucesso){
                    $('#resultado').html(data.html);
                }else{
                    $('#resultado').html(data.mensagem);
                }
                $this.button('reset');
            });
            return false;
    });

    $('body').on('change','#ra_aluno',function(){
        $('#frmHorasRealizadasAluno').submit();
    });

    $('#ra_aluno').select2({
       language: "pt-BR",
       placeholder: "Selecione o Aluno"
    });
});//document ready

