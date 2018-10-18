<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>AACC</title>
        <link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet"/>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url('assets/font-awesome/css/font-awesome.min.css');?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url('assets/css/AdminLTE.min.css');?>">
        <link href="<?=base_url('assets/css/login.css');?>" rel="stylesheet"/>
    </head>
    <body>
        <div class="container center">
      <!-- Default box -->
      <div class="box box-primary">
          <?php $atributos = array('id' => 'frmRecovering', 'name' => 'frmRecovering'); echo form_open('login/confirm-recovered', $atributos);?>
          <input type="hidden" id="nivel" name="nivel" value="<?=$nivel;?>">
        <div class="box-header with-border">
            <h3 class="box-title">Login - Recuperação</h3>
        </div>
        <div class="box-body">
            
            <?= validation_errors();?>
            
            <div id="erro" style="color:#ff0000;margin:5px;text-align: center;"><?=(isset($erro))?$erro:'';?></div>
            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" id="email" name="email" placeholder="Email" type="text" value="<?=set_value('email');?>" autofocus>
            </div>          
            <div class="form-group">
                <label for="senha">Senha</label>
                <input class="form-control" id="senha" name="senha" placeholder="Senha" type="password">
                <p class="help-block">Informe seu Email.<br/>Informe a Nova Senha recebida no Email.<br/>Você será redirecionado(a) para a tela de Login.</p>
            </div>  
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Confirmar</button>
            <a class="btn btn-default" href="<?=base_url('login');?>">Cancelar</a>
        </div>
        <!-- /.box-footer-->
        <?=form_close();?>
      </div>
      <!-- /.box -->         
        </div>
        
        
        <script src="<?=base_url('assets/js/jquery.min.js');?>" type="text/javascript"></script>
        <script src="<?=base_url('assets/js/bootstrap.min.js');?>" type="text/javascript"></script>
    </body>
</html>