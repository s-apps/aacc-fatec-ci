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
            url: base_url+'admin/modalidade/lista',
            type: 'GET',
            data:{busca:busca}
            }).done(function(data) {
                data = JSON.parse(data);
                $('#lista_tbody').html(data.html);
            });      
    });

    $('body').on('click','#btnAddCategoria',function(){
        $.ajax({
        url: base_url+'admin/modalidade/addCategoria'
        }).done(function(data) {
            data = JSON.parse(data);
            $('.modal-content').html(data.html);
            $('#addExtra').modal('show'); 
        });
        return false;
    }); 

    $('body').on('click','#btnAddComprovante',function(){
        $.ajax({
        url: base_url+'admin/modalidade/addComprovante'
        }).done(function(data) {
            data = JSON.parse(data);
            $('.modal-content').html(data.html);
            $('#addExtra').modal('show'); 
        });
        return false;
    }); 

    $('body').on('submit','#frmAddCategoriaExtra',function(){
        var categoriaExtra = $('#categoriaExtra').val();
        $.ajax({
            url: base_url+'admin/categoria/addCategoriaExtra',
            type: 'POST',
            data: {categoriaExtra:categoriaExtra}
            }).done(function(data) {
                data = JSON.parse(data);
                if(data.sucesso){
                    $('#id_categoria').append(new Option(data.nome_categoria, data.id_categoria, true, true));
                    $('#addExtra').modal('hide');                    
                }else{
                    $('#erroExtra').html(data.erro);
                }
            });
            return false;
    });
    $('body').on('submit','#frmAddComprovanteExtra',function(){
        var comprovanteExtra = $('#comprovanteExtra').val();
        $.ajax({
            url: base_url+'admin/comprovante/addComprovanteExtra',
            type: 'POST',
            data: {comprovanteExtra:comprovanteExtra}
            }).done(function(data) {
                data = JSON.parse(data);
                if(data.sucesso){
                    $('#id_comprovante').append(new Option(data.nome_comprovante, data.id_comprovante, true, true));
                    $('#addExtra').modal('hide');                    
                }else{
                    $('#erroExtra').html(data.erro);
                }
            });
            return false;
    });

   $('#id_categoria').select2({
       language: "pt-BR",
       placeholder: "Selecione uma Categoria"
    });
   $('#id_comprovante').select2({
       language: "pt-BR",
       placeholder: "Selecione um Comprovante"
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
    $('#duracao_modalidade').on('keydown',function(e){
        var keycode = (window.event) ? event.keyCode : e.keyCode;
           if (keycode === 9)      {
               $(this).timepicker('hideWidget');
           }
    });
    $('#limite_modalidade').on('keydown',function(e){
        var keycode = (window.event) ? event.keyCode : e.keyCode;
           if (keycode == 9)      {
               $(this).timepicker('hideWidget');
           }
    });    
    $('[data-toggle="tooltip"]').tooltip();
});//document ready

