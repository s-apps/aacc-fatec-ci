var base_url = 'https://aacc.silverio.eti.br/';

$(document).ready(function() {

    editaCampos();

    function editaCampos(){
        var formulario = $('#modeloCertificado').data('formulario');
        if(formulario=='EdtAtividade'){
            $('#loadingGif').show();
            var id_certificado = $('#modeloCertificado').val();
            var id_atividade = $('#id_atividade').val();
            $.ajax({
                url: base_url+'admin/atividade/editaCamposCertificado',
                type: 'GET',
                data:{id_atividade:id_atividade,id_certificado:id_certificado}
                }).done(function(data) {
                    data = JSON.parse(data);
                    $('#loadingGif').hide();
                    $('#campos_certificado').html(data.campos_certificado);
                    $('#campos_certificado').show();
            });
        }
    }

    $('#buscar').on('keyup',function(){
        var busca = $(this).val();
        if(busca.lenght===0){
            $('.box-footer').show();
        }else{
            $('.box-footer').hide();
        }
        $.ajax({
            url: base_url+'admin/atividade/lista',
            type: 'GET',
            data:{busca:busca}
            }).done(function(data) {
                data = JSON.parse(data);
                $('#lista_tbody').html(data.html);
            });      
    });

    $('body').on('change','#modeloCertificado',function(){
        var formulario = $('#modeloCertificado').data('formulario');
        $('#campos_certificado').hide();
        $('#loadingGif').show();
        var id_certificado = $('#modeloCertificado').val();
        if(formulario=='AddAtividade'){
            $.ajax({
                url: base_url+'admin/atividade/carregaCamposCertificado',
                type: 'GET',
                data:{id_certificado:id_certificado}
                }).done(function(data) {
                    data = JSON.parse(data);
                    $('#loadingGif').hide();
                    $('#campos_certificado').html(data.campos_certificado);
                    $('#campos_certificado').show();
            });
        }else{
            editaCampos();
        }

    });
    
    $('body').on('click','#btnGerarCertificado',function(){
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

    $('body').on('click','#btnPreverCertificado',function(){
        var $this = $(this);
        $this.button('loading');

        var data_atividade = ($('#data_atividade').val()==='')?'09/09/2019':$('#data_atividade').val();
        var carga_horaria = ($('#carga_horaria').val()==='')?'09':$('#carga_horaria').val();
        var descricao_atividade = ($('#descricao_atividade').val()==='')?'Descrição da atividade não informada':$('#descricao_atividade').val();
        var ra_aluno = $('#ra_aluno').val();
        var id_modalidade = $('#id_modalidade').val();
        var modeloCertificado = $('#modeloCertificado').val();

        var evento = ($('#evento').val()==='')?'Evento não informado':$('#evento').val();
        var periodo = ($('#periodo').val()==='')?'Periodo não informado':$('#periodo').val();
        var nome_trabalho = ($('#nome_trabalho').val()==='')?'Nome do Trabalho não informado':$('#nome_trabalho').val();
        var local_apresentacao = ($('#local_apresentacao').val()==='')?'Local da Apresentação não informado':$('#local_apresentacao').val();
        var titulo_monografia = ($('#titulo_monografia').val()==='')?'Título da Monografia não informado':$('#titulo_monografia').val();
        var subtitulo_monografia = ($('#subtitulo_monografia').val()==='')?'Subtítulo da Monografia não informado':$('#subtitulo_monografia').val();
        var nome_completo_orientando = ($('#nome_completo_orientando').val()==='')?'Nome Completo do Orientando não informado':$('#nome_completo_orientando').val();
        var do_curso_superior_de = ($('#do_curso_superior_de').val()==='')?'Do Curso Superior de não informado':$('#do_curso_superior_de').val();
        var nome_evento = ($('#nome_evento').val()==='')?'Nome do Evento não informado':$('#nome_evento').val();
        var promovido_por = ($('#promovido_por').val()==='')?'Promovido por não informado':$('#promovido_por').val();
        var nome_exposicao = ($('#nome_exposicao').val()==='')?'Nome da Exposição não informada':$('#nome_exposicao').val();
        var periodo_exposicao = ($('#periodo_exposicao').val()==='')?'Período da Exposição não informado':$('#periodo_exposicao').val();
        var nome_minicurso = ($('#nome_minicurso').val()==='')?'Nome do Minicurso não informado':$('#nome_minicurso').val();
        var nome_responsavel_minicurso = ($('#nome_responsavel_minicurso').val()==='')?'Nome do Responsável não informado':$('#nome_responsavel_minicurso').val();
        var local_minicurso = ($('#local_minicurso').val()==='')?'Local não informado':$('#local_minicurso').val();
        var local_realizacao = ($('#local_realizacao').val()==='')?'Local da Realização não informado':$('#local_realizacao').val();
        var workshop = ($('#workshop').val()==='')?'Workshop não informado':$('#workshop').val();
        var nome_palestra_aluno = ($('#nome_palestra_aluno')==='')?'Nome da Palestra não informado':$('#nome_palestra_aluno').val();
        var nome_responsavel_palestra_aluno = ($('#nome_responsavel_palestra_aluno').val()==='')?'Nome do Responsável não informado':$('#nome_responsavel_palestra_aluno').val();
        var local_palestra_aluno = ($('#local_palestra_aluno').val()==='')?'Local não informado':$('#local_palestra_aluno').val();
        var nome_palestra_palestrante = ($('#nome_palestra_palestrante').val()==='')?'Nome da Palestra não informado':$('#nome_palestra_palestrante').val();
        var periodo_palestra_palestrante = ($('#periodo_palestra_palestrante').val()==='')?'Período não informado':$('#periodo_palestra_palestrante').val();
        var local_palestra_palestrante = ($('#local_palestra_palestrante').val()==='')?'Local não informado':$('#local_palestra_palestrante').val();
        var nome_empresa = ($('#nome_empresa').val()==='')?'Nome da Empresa não informado':$('#nome_empresa').val();
        var municipio_empresa = ($('#municipio_empresa').val()==='')?'Município Empresa não informado':$('#municipio_empresa').val();

        $.ajax({
            url: base_url+'admin/certificado/prever',
            type: 'GET',
            data:{
                modeloCertificado:modeloCertificado,
                data_atividade:data_atividade,
                carga_horaria:carga_horaria,
                descricao_atividade:descricao_atividade,
                ra_aluno:ra_aluno,
                id_modalidade:id_modalidade,
                evento:evento,
                periodo:periodo,
                nome_trabalho:nome_trabalho,
                local_apresentacao:local_apresentacao,
                titulo_monografia:titulo_monografia,
                subtitulo_monografia:subtitulo_monografia,
                nome_completo_orientando:nome_completo_orientando,
                do_curso_superior_de:do_curso_superior_de,
                nome_evento:nome_evento,
                promovido_por:promovido_por,
                nome_exposicao:nome_exposicao,
                periodo_exposicao:periodo_exposicao,
                nome_minicurso:nome_minicurso,
                nome_responsavel_minicurso:nome_responsavel_minicurso,
                local_minicurso:local_minicurso,
                local_realizacao:local_realizacao,
                workshop:workshop,
                nome_palestra_aluno:nome_palestra_aluno,
                nome_responsavel_palestra_aluno:nome_responsavel_palestra_aluno,
                local_palestra_aluno:local_palestra_aluno,
                nome_palestra_palestrante:nome_palestra_palestrante,
                periodo_palestra_palestrante:periodo_palestra_palestrante,
                local_palestra_palestrante:local_palestra_palestrante,
                nome_empresa:nome_empresa,
                municipio_empresa:municipio_empresa
            }
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
    
    $(".timepicker").timepicker({
        autoclose:true,
        showInputs: false,
        showMeridian:false,
        defaultTime:'1:00',
        minuteStep:5,icons:{
             up: 'glyphicon glyphicon-plus',
             down: 'glyphicon glyphicon-minus'
        }
     });   

     $('#data_atividade').inputmask({
        mask: 'd/m/y',
        placeholder: 'dd/mm/aaaa',
        'onincomplete': function(){
            $('#data_atividade').val('');
        }
    });     
 
    $('#ra_aluno').select2({
       language: "pt-BR",
       placeholder: "Selecione o Aluno"
    });
    $('#id_modalidade').select2({
        language: "pt-BR",
        placeholder: "Selecione a Modalidade"
     });
     $('#modeloCertificado').select2({
        language: "pt-BR",
        placeholder: "Selecione o Certificado"
     });
 
});//document ready

