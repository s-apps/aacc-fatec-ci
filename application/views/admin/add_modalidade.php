  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Modalidades <small>adicionando</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
          <?php $atributos = array('id' => 'frmAddModalidade', 'name' => 'frmAddModalidade'); echo form_open('admin/modalidade/inserir', $atributos);?>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-0">
                    <div class="form-group">
                        <label for="id_categoria">Categoria</label>
                        <div class="input-group">
                            <select class="form-control" id="id_categoria" name="id_categoria">
                                <option></option>
                                <?php foreach ($categorias as $categoria){
                                    echo '<option value="'.$categoria->id_categoria.'">'.$categoria->nome_categoria.'</option>';
                                }
                                ?>
                            </select>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-flat" type="button" id="btnAddCategoria" data-toggle="tooltip" data-placement="right" title="Adicionar Categoria"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <p class="help-block"><?= form_error('id_categoria'); ?></p>
                    </div>
                    <div class="form-group">
                        <label for="nome_modalidade">Modalidade</label>
                        <textarea class="form-control" rows="3" placeholder="Informe a modalidade" id="nome_modalidade" name="nome_modalidade" style="resize: none;"><?=set_value('nome_modalidade')?></textarea>
                        <p class="help-block"><?= form_error('nome_modalidade'); ?></p>
                    </div>     
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="duracao_modalidade">Duração</label>
                                <input type="text" class="form-control timepicker" id="duracao_modalidade" name="duracao_modalidade" value="">
                                <p class="help-block"><?= form_error('duracao_modalidade'); ?></p>
                            </div>        
                        </div><!--col-md-6-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="limite_modalidade">Limite</label>
                                <input type="text" class="form-control timepicker" id="limite_modalidade" name="limite_modalidade" value="">
                                <p class="help-block"><?= form_error('limite_modalidade'); ?></p>
                            </div>        
                        </div><!--col-md-6-->
                    </div><!--row-->    
                    <div class="form-group">
                        <label for="id_comprovante">Comprovante</label>
                        <div class="input-group">
                            <select class="form-control" id="id_comprovante" name="id_comprovante">
                                <option></option>
                                <?php foreach ($comprovantes as $comprovante){
                                    echo '<option value="'.$comprovante->id_comprovante.'">'.$comprovante->nome_comprovante.'</option>';
                                }
                                ?>
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
        </div>
        <!-- /.box-footer-->
        <?php echo form_close();?>
      </div>
      <!-- /.box -->

        <div class="modal" id="addExtra" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                                
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->      


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->