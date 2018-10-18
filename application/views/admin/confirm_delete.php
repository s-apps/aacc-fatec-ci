 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-trash-o"></i> Deseja Realmente Excluir?</h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box box-warning">
        <?php $atributos = array('id' => 'frmDelete', 'name' => 'frmDelete'); echo form_open('admin/'.$dados['from'].'/delete', $atributos);?>
            <input type="hidden" id="chave_primaria" name="chave_primaria" value="<?=$dados['chave_primaria'];?>">
            <div class="box-header with-border">
                <h3 class="box-title"><?=strtoupper($dados['from']);?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?=$html;?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-trash-o"></i> Excluir</button>
                <a href="<?=base_url($dados['link']);?>" class="btn btn-default"><i class="fa fa-undo"></i> Cancelar</a>
            </div>  
            <?=form_close();?>
        </div>
    </section>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

