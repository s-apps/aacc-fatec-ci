  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-cubes"></i> Atividades <small>listando</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
        <div class="row">
            <div class="col-md-8">
                <a href="<?=base_url('admin/atividade/adicionar');?>" class="btn btn-primary"><i class="fa fa-plus"></i> Adicionar</a>
            </div><!--col-md-8-->
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-search"></i>
                    </div>
                    <input class="form-control" id="buscar" name="buscar" placeholder="Buscar por Atividade, RA ou Aluno" type="text">
                </div>                
            </div><!--col-md-4-->
        </div><!--row-->
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Data</th>
                  <th>Atividade</th>
                  <!--<th>Modalidade</th>-->
                  <th>RA</th>
                  <th>Aluno</th>
                  <th colspan="3"></th>
                </tr>
              </thead>
              <tbody id="lista_tbody">
                <?php foreach ($lista->result() as $atividade){?>
                  <tr>
                    <td style="vertical-align : middle;"><?= date('d/m/Y',strtotime($atividade->data_atividade));?></td>
                    <td style="vertical-align : middle;"><?=$atividade->descricao_atividade;?></td>
                    <td style="vertical-align : middle;"><?=$atividade->ra_aluno;?></td>
                    <td style="vertical-align : middle;"><?=$atividade->nome_aluno;?></td>
                    <td style="width: 5%;text-align: center;vertical-align : middle;"><a href="<?= base_url('admin/atividade/editar/'.$atividade->id_atividade);?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Editar</a></td>
                    <td style="width: 5%;text-align: center;vertical-align : middle;"><a href="<?= base_url('admin/atividade/confirm-delete/'.$atividade->id_atividade);?>" class="btn btn-warning btn-xs"><i class="fa fa-trash-o"></i> Excluir</button></td>
                    <td style="width: 5%;text-align: center;vertical-align : middle;"><button class="btn btn-default btn-xs" type="button" id="btnGerarCertificado" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Aguarde..." data-id_atividade="<?=$atividade->id_atividade;?>"><i class="fa fa-file-pdf-o"></i> Certificado</button></td>
                  </tr>
                <?php }?>
              </tbody>
            </table>            
          </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <?=$paginacao;?>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->