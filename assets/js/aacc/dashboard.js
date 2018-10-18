var base_url = 'https://aacc.silverio.eti.br/';

$(document).ready(function() {


    carregaAvisos();

    $('#btnAdicionar').on('click',function(){
        limparCampos();
        ligaBotoes();
        $.ajax({
            url: base_url+'admin/dashboard/add_aviso'
            }).done(function(data) {
                data = JSON.parse(data);
                $('#data_aviso').val(data.data_aviso);
                $('#titulo_aviso').focus();
                $('html, body').animate({ scrollTop: 0 }, 'fast');
        });
    });

    $('#btnCancelar').on('click',function(){
        limparCampos();
        $('#aviso').val('');
        desligaBotoes();
    });

    $('#btnSalvar').on('click',function(){
        var data_aviso = $('#data_aviso').val();
        var titulo_aviso = $('#titulo_aviso').val();
        var aviso = $('#aviso').val();
        $('#mensagemAviso').html('');
        $('#mensagemAviso').show();
        $.ajax({
            url: base_url+'admin/dashboard/salvar_aviso',
            type: 'GET',
            data:{data_aviso:data_aviso,titulo_aviso:titulo_aviso,aviso:aviso}
            }).done(function(data) {
                data = JSON.parse(data);
                if(data.sucesso){
                    limparCampos();
                    desligaBotoes();
                    carregaAvisos();
                }
                $('#mensagemAviso').html(data.mensagem).delay(2000).fadeOut();
        });
        return false;
    });

    $('body').on('click','#btnExcluirAviso',function(){
        var id_aviso = $(this).data('id_aviso');
        $.ajax({
            url: base_url+'admin/dashboard/excluir_aviso',
            type: 'GET',
            data:{id_aviso:id_aviso}
            }).done(function(data) {
                data = JSON.parse(data);
                if(data.sucesso){
                    carregaAvisos();
                }
                $('#mensagemAviso').html(data.mensagem).delay(2000).fadeOut();
        });
        return false;
    });    
    
    function ligaBotoes(){
        $('#btnAdicionar').prop("disabled",true);
        $('#btnSalvar').prop("disabled",false);
        $('#btnCancelar').prop("disabled",false);
        $('#data_aviso').prop("disabled",false);
        $('#titulo_aviso').prop("disabled",false);
        $('#aviso').prop("disabled",false);
    }

    function desligaBotoes(){
        $('#btnAdicionar').prop("disabled",false);
        $('#btnSalvar').prop("disabled",true);
        $('#btnCancelar').prop("disabled",true);
        $('#data_aviso').prop("disabled",true);
        $('#titulo_aviso').prop("disabled",true);
        $('#aviso').prop("disabled",true);
    }

    function limparCampos(){
        $('#mensagemAviso').html('');
        $('#data_aviso').val('');
        $('#titulo_aviso').val('');
        $('#aviso').val('');
    }

    function carregaAvisos(){
        $.ajax({
            url: base_url+'admin/dashboard/carrega_avisos',
            }).done(function(data) {
                data = JSON.parse(data);
                $('#accordion').html(data.html);
        });        
    }
    
    $('#data_aviso').inputmask({
        mask: 'd/m/y',
        placeholder: 'dd/mm/aaaa',
        'onincomplete': function(){
            $('#data_aviso').val('');
        }
    });     


});//document ready

