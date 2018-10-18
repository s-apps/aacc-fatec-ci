  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Categorias <small>adicionando</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
          <?php $atributos = array('id' => 'frmAddCategoria', 'name' => 'frmAddCategoria'); echo form_open('admin/categoria/inserir', $atributos);?>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-0">
                    <div class="form-group">
                        <label for="nome_categoria">Categoria</label>
                        <input type="text" class="form-control" id="nome_categoria" name="nome_categoria" placeholder="Informe a Categoria" value="<?= set_value('nome_categoria');?>" autofocus="autofocus">
                        <p class="help-block"><?= form_error('nome_categoria'); ?></p>
                    </div>
                </div>
            </div><!--row-->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Salvar</button>
            <a href="<?=base_url('admin/categoria/lista');?>" class="btn btn-default"><i class="fa fa-undo"></i> Cancelar</a>
        </div>
        <!-- /.box-footer-->
        <?php echo form_close();?>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->