  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Modalidades <small>editando</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
          <?php $atributos = array('id' => 'frmEdtModalidade', 'name' => 'frmEdtModalidade'); echo form_open('admin/modalidade/atualizar', $atributos);?>
          <input type="hidden" id="id_modalidade" name="id_modalidade" value="<?=$modalidade->id_modalidade;?>">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-0">
                    <div class="form-group">
                        <label for="id_categoria">Categoria</label>
                        <div class="input-group">
                            <select class="form-control" id="id_categoria" name="id_categoria">
                                <option></option>
                                <?php foreach ($categorias as $categoria){?>
                                    <option value="<?=$categoria->id_categoria;?>"<?=($categoria->id_categoria==$modalidade->id_categoria)?' selected="selected"':'';?>><?=$categoria->nome_categoria;?></option>
                                <?php } ?>
                            </select>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-flat" type="button" id="btnAddCategoria" data-toggle="tooltip" data-placement="right" title="Adicionar Categoria"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <p class="help-block"><?= form_error('id_categoria'); ?></p>
                    </div>
                    <div class="form-group">
                        <label for="nome_modalidade">Modalidade</label>
                        <textarea class="form-control" rows="3" placeholder="Informe a modalidade" id="nome_modalidade" name="nome_modalidade" style="resize: none;"><?=set_value('nome_modalidade',$modalidade->nome_modalidade)?></textarea>
                        <p class="help-block"><?= form_error('nome_modalidade'); ?></p>
                    </div>     
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="duracao_modalidade">Duração</label>
                                <input type="text" class="form-control timepicker" id="duracao_modalidade" name="duracao_modalidade" value="<?=$modalidade->duracao_modalidade;?>">
                                <p class="help-block"><?= form_error('duracao_modalidade'); ?></p>
                            </div>        
                        </div><!--col-md-6-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="limite_modalidade">Limite</label>
                                <input type="text" class="form-control timepicker" id="limite_modalidade" name="limite_modalidade" value="<?=$modalidade->limite_modalidade;?>">
                                <p class="help-block"><?= form_error('limite_modalidade'); ?></p>
                            </div>        
                        </div><!--col-md-6-->
                    </div><!--row-->    
                    <div class="form-group">
                        <label for="id_comprovante">Comprovante</label>
                        <div class="input-group">
                            <select class="form-control" id="id_comprovante" name="id_comprovante">
                                <option></option>
                                <?php foreach ($comprovantes as $comprovante){?>
                                    <option value="<?=$comprovante->id_comprovante;?>"<?=($comprovante->id_comprovante==$modalidade->id_comprovante)?' selected="selected"':'';?>><?=$comprovante->nome_comprovante;?></option>
                                <?php } ?>
                            </select>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-flat" type="button" id="btnAddComprovante" data-toggle="tooltip" data-placement="right" title="Adicionar Comprovante"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <p class="help-block"><?= form_error('id_comprovante'); ?></p>
                    </div>
                </div>
            </div><!--row-->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Salvar</button>
            <a href="<?=base_url('admin/modalidade/lista');?>" class="btn btn-default"><i class="fa fa-undo"></i> Cancelar</a>
            <a href="<?= base_url('admin/modalidade/confirm-delete/'.$modalidade->id_modalidade);?>" class="btn btn-warning"><i class="fa fa-trash-o"></i> Excluir</a>            
        </div>
        <!-- /.box-footer-->
        <?php echo form_close();?>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->