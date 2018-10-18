  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Comprovantes <small>editando</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <?php $atributos = array('id' => 'frmEdtComprovante', 'name' => 'frmEdtComprovante'); echo form_open('admin/comprovante/atualizar', $atributos);?>
          <input type="hidden" id="id_comprovante" name="id_comprovante" value="<?=$comprovante->id_comprovante;?>">  
        <div class="box-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-0">
                    <div class="form-group">
                        <label for="nome_comprovante">Comprovante</label>
                        <input type="text" class="form-control" id="nome_comprovante" name="nome_comprovante" placeholder="Informe o Comprovante" value="<?= set_value('nome_comprovante',$comprovante->nome_comprovante);?>" autofocus="autofocus">
                        <p class="help-block"><?= form_error('nome_comprovante'); ?></p>
                    </div>
                </div>
            </div><!--row-->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Salvar</button>
            <a href="<?=base_url('admin/comprovante/lista');?>" class="btn btn-default"><i class="fa fa-undo"></i> Cancelar</a>
        </div>
        <!-- /.box-footer-->
        <?php echo form_close();?>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->