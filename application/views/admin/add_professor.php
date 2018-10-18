  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Professores <small>adicionando</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
          <?php $atributos = array('id' => 'frmAddProfessor', 'name' => 'frmAddProfessor'); echo form_open('admin/professor/inserir', $atributos);?>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nome_professor">Nome completo</label>
                        <input type="text" class="form-control maiusculo" id="nome_professor" name="nome_professor" placeholder="Informe o Nome completo" value="<?= set_value('nome_professor');?>">
                        <p class="help-block"><?= form_error('nome_professor'); ?></p>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Informe o Email" value="<?= set_value('email');?>">
                                <p class="help-block"><?= form_error('email'); ?></p>
                            </div>
                        </div><!--col-md-8-->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="senha">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" placeholder="Informe a Senha" value="<?= set_value('senha');?>">
                                <p class="help-block"><?= form_error('senha'); ?></p>
                            </div>
                        </div><!--col-md-4-->
                    </div><!--row-->
                </div>
                <div class="col-md-6">
                <h4>Cursos que leciona</h4>
                    <?php foreach ($cursos as $curso) { ?>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="cursosleciona[]" value="<?php echo $curso->id_curso;?>">
                            <?php echo $curso->nome_curso;?>
                        </label>
                    </div>
                    <?php }?>
                </div><!--col-md-6-->
            </div><!--row-->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Salvar</button>
            <a href="<?=base_url('admin/professor/lista');?>" class="btn btn-default"><i class="fa fa-undo"></i> Cancelar</a>
        </div>
        <!-- /.box-footer-->
        <?php echo form_close();?>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->