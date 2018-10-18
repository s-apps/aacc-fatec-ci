  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Atividades <small>editando</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
      <?php $atributos = array('id' => 'frmEdtAtividade', 'name' => 'frmEdtAtividade'); echo form_open('admin/atividade/atualizar', $atributos);?>
      <input type="hidden" id="id_atividade" name="id_atividade" value="<?=$atividade->id_atividade;?>">
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="data_atividade">Data da Atividade</label>
                      <input type="text" class="form-control" id="data_atividade" name="data_atividade" value="<?= set_value('data_atividade',date('d/m/Y',strtotime($atividade->data_atividade)));?>" autofocus="autofocus">
                      <?= form_error('data_atividade'); ?>
                  </div>
                </div><!--col-md-6-->
                <div class="col-md-6">
                <div class="form-group">
                    <label for="carga_horaria">Carga Horária</label>
                      <input type="text" class="form-control timepicker" id="carga_horaria" name="carga_horaria" value="<?= set_value('carga_horaria',$atividade->carga_horaria);?>">
                      <?= form_error('carga_horaria'); ?>
                  </div>
                </div><!--col-md-6-->
              </div><!--row-->
              <div class="form-group">
                <label for="descricao_atividade">Atividade</label>
                  <textarea class="form-control" rows="5" placeholder="Informe a Atividade" id="descricao_atividade" name="descricao_atividade" style="resize: none;"><?=set_value('descricao_atividade',$atividade->descricao_atividade)?></textarea>
                  <?= form_error('descricao_atividade'); ?>
              </div> 
              <div class="form-group">
                <label for="ra_aluno">Aluno</label>
                  <select class="form-control" id="ra_aluno" name="ra_aluno">
                    <option></option>
                    <?php foreach($alunos as $aluno){?>
                    <option value="<?=$aluno->ra;?>"<?=set_select('ra_aluno',$aluno->ra);?><?=($aluno->ra==$atividade->ra_aluno)?' selected="selected"':'';?>><?=$aluno->ra;?> | <?=$aluno->nome_aluno;?></option>
                    <?php }?>
                  </select>
                  <?= form_error('ra_aluno'); ?>
              </div>
              <div class="form-group">
                <label for="id_modalidade">Modalidade</label>
                  <select class="form-control" id="id_modalidade" name="id_modalidade">
                    <option></option>
                    <?php foreach($modalidades as $modalidade){?>
                    <option value="<?=$modalidade->id_modalidade;?>"<?=set_select('id_modalidade',$modalidade->id_modalidade);?><?=($modalidade->id_modalidade==$atividade->id_modalidade)?' selected="selected"':'';?>><?=$modalidade->nome_modalidade;?></option>
                    <?php }?>
                  </select>
                  <?= form_error('id_modalidade'); ?>
              </div>
            </div><!--col-md-6-->
            <div class="col-md-6">
              <div class="well">
                        <div class="form-group">
                            <label for="modeloCertificado">Certificado</label>
                            <div class="input-group">
                                <select class="form-control select2" id="modeloCertificado" name="modeloCertificado" data-formulario="EdtAtividade">
                                    <option></option>
                                    <?php foreach($certificados as $certificado) {?>
                                    <option value="<?=$certificado->id_certificado;?>"<?=set_select('modeloCertificado',$certificado->id_certificado);?><?=($certificado->id_certificado==$atividade->id_certificado)?' selected="selected"':'';?>><?=$certificado->nome_certificado;?></option>
                                    <?php } ?>
                                </select>
                                <div class="input-group-btn">
                                    <button class="btn btn-primary btn-flat" type="button" id="btnPreverCertificado" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processando"><i class="fa fa-file-pdf-o"></i> Pré-visualizar</button>
                                </div>
                            </div>
                            <?=form_error('modeloCertificado');?>
                        </div>
                        <div id="loadingGif"><img src="<?=base_url('assets/img/ajax-loader.gif');?>"><br/>Aguarde</div>
                        <div id="campos_certificado"></div>
                    </div>            
            </div><!--col-md-6-->
          </div><!--row-->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Salvar</button>
          <a href="<?=base_url('admin/atividade/lista');?>" class="btn btn-default"><i class="fa fa-undo"></i> Cancelar</a>
          <a href="<?=base_url('admin/atividade/confirm-delete/'.$atividade->id_atividade);?>" class="btn btn-warning"><i class="fa fa-trash-o"></i> Excluir</a>
        </div>
        <!-- /.box-footer-->
        <?= form_close();?>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
