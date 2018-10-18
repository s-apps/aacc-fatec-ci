  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-dashboard"></i> Painel de Controle</h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-6">
          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">AVISOS</h3>
            </div>
            <div class="box-body" id="frmAviso">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input class="form-control input-sm" id="data_aviso" name="data_aviso" value="" type="text" disabled>
                  </div>                
                </div><!--col-md-3-->
                <div class="col-md-9">
                  <div class="form-group">
                    <input class="form-control input-sm" id="titulo_aviso" name="titulo_aviso" placeholder="Título" value="" type="text" disabled>
                  </div>                
                </div><!--col-md-9-->
              </div><!--row-->
              <div class="form-group">
                <textarea class="form-control input-sm" rows="2" id="aviso" name="aviso" placeholder="Aviso" style="resize:none;" disabled></textarea>
              </div>
              <div id="mensagemAviso" style="margin-bottom:5px;"></div>
              <button type="button" id="btnAdicionar" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Adicionar</button>
              <button type="submit" id="btnSalvar" class="btn btn-primary btn-sm" disabled="disabled"><i class="fa fa-floppy-o"></i> Salvar</button>
              <button type="submit" id="btnCancelar" class="btn btn-primary btn-sm" disabled="disabled"><i class="fa fa-undo"></i> Cancelar</button>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="box-group" id="accordion"></div>
            </div>
            <!-- /.box-footer-->

          </div>
        <!-- /.box -->
        
        </div><!--col-md-6-->
        <div class="col-md-6">
          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">BANCO DE DADOS BACKUP</h3>
            </div>
            <div class="box-body">
              <a class="btn btn-primary" href="<?=base_url('admin/dashboard/backup');?>">Fazer backup</a>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <p>A <strong>restauração</strong> é de responsabilidade do administrador do banco de dados</p>
           <!-- /.box-footer-->
          </div>
        <!-- /.box -->
          </div>

          <!-- Default box -->
          <div class="box">
          <?php $atributos = array('id' => 'frmConfig', 'name' => 'frmConfig'); echo form_open_multipart('admin/dashboard/config-update', $atributos);?>
            <div class="box-header with-border">
              <h3 class="box-title">CONFIGURAÇÕES</h3>
            </div>
            <div class="box-body">
              <?=validation_errors();?>
                                  <div class="well">

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="limite_atividade">Limite Atividades</label>
                    <input type="number" class="form-control" id="limite_atividade" name="limite_atividade" value="<?=set_value('limite_atividade',$config->limite_atividade);?>" maxlength="2">
                  </div>
                </div>
                  <div class="col-md-8">
                      <p>Número máximo em horas das atividades do aluno</p>
                  </div>
                  </div>
              </div>
                
              <div class="form-group">
                <label for="nome_diretor">Diretor(a) Fatec Garça </label>
                <input type="text" class="form-control" id="nome_diretor" name="nome_diretor" value="<?=set_value('nome_diretor',$config->nome_diretor);?>"placeholder="Nome do Diretor(a)">
              </div>
                <div class="panel panel-default flat">
  <div class="panel-body">
              <div class="form-group">
                <label for="assinatura">Assinatura Digitalizada (GIF, PNG ou JPG)</label>
                <input type="file" id="assinatura" name="assinatura">
              </div>      
                <?=($config->assinatura!=null)?
                '<div id="imagemAssinatura">
                    <img src="'.base_url('assets/img/assinatura/'.$config->assinatura).'">
                </div>':'';?>
                </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
             <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i> Salvar configurações</button>
            </div>
           <!-- /.box-footer-->
           <?=form_close();?>
          </div>
        <!-- /.box -->

        
        </div><!--col-md-6-->
      </div><!--row-->


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->