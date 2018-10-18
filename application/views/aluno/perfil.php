  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-user"></i> Dados Pessoais</h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-0">
                                    <div class="form-group">
                                        <label for="ra">RA</label>
                                        <input type="text" class="form-control" id="ra" name="ra" value="<?=$aluno->ra;?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nome_aluno">Nome</label>
                                <input type="text" class="form-control" id="nome_aluno" name="nome_aluno" value="<?=$aluno->nome_aluno;?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="<?=$aluno->email;?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="nome_curso">Curso</label>
                                <input type="text" class="form-control" id="nome_curso" name="nome_curso" value="<?=$aluno->nome_curso;?>" disabled>
                            </div>
                    </div><!--col-md-6-->
                    <div class="col-md-6">
                        <?=(isset($mensagem))?$mensagem:'';?>
                        <?php $atributos = array('id' => 'frmUpdPerfil', 'name' => 'frmUpdPerfil'); echo form_open('aluno/perfil/atualizar', $atributos);?>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-0">
                                    <div class="form-group">
                                        <label for="senha_antiga">Senha Antiga</label>
                                        <input type="password" class="form-control" id="senha_antiga" name="senha_antiga" value="" minlength="4">
                                        <?= form_error('senha_antiga'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="senha">Nova Senha</label>
                                        <input type="password" class="form-control" id="senha" name="senha" value="" minlength="4">
                                        <?= form_error('senha'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="senha_repeat">Repita a Nova Senha </label>
                                        <input type="password" class="form-control" id="senha_repeat" name="senha_repeat" value="" minlength="4">
                                        <?= form_error('senha_repeat'); ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-lock"></i> Alterar Senha</button>
                                </div>
                            </div>
                        <?=form_close();?>
                    </div><!--col-md-6-->
                </div><!--row-->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                
            </div>
            <!-- box-footer -->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->