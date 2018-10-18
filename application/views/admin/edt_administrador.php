  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Administradores <small>editando</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
          <?php $atributos = array('id' => 'frmEdtAdministrador', 'name' => 'frmEdtAdministrador'); echo form_open('admin/administrador/atualizar', $atributos);?>
          <input type="hidden" id="id_administrador" name="id_administrador" value="<?=$administrador->id_administrador;?>">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-0">
                    <div class="form-group">
                        <label for="nome_administrador">Nome completo</label>
                        <input type="text" class="form-control maiusculo" id="nome_administrador" name="nome_administrador" placeholder="Informe o Nome completo" value="<?= set_value('nome_administrador',$administrador->nome_administrador);?>" autofocus="autofocus">
                        <p class="help-block"><?= form_error('nome_administrador'); ?></p>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Informe o Email" value="<?= set_value('email',$administrador->email);?>">
                                <p class="help-block"><?= form_error('email'); ?></p>
                            </div>
                        </div><!--col-md-8-->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="senha">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" placeholder="Informe a Senha" value="<?= set_value('senha');?>" minlength="4">
                                <p class="help-block"><?= form_error('senha'); ?></p>
                            </div>
                        </div><!--col-md-4-->
                    </div><!--row-->
                    <p>Obs: Informe a Senha somente caso queira alterá-la. Do contrário, deixar em branco.</p>
                </div>
            </div><!--row-->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Salvar</button>
            <a href="<?=base_url('admin/administrador/lista');?>" class="btn btn-default"><i class="fa fa-undo"></i> Cancelar</a>
            <a class="btn btn-warning" href="<?=base_url('admin/administrador/confirm-delete/'.$administrador->id_administrador);?>"><i class="fa fa-trash-o"></i> Excluir</a>
        </div>
        <!-- /.box-footer-->
        <?php echo form_close();?>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->