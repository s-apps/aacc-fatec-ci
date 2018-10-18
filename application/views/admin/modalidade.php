  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><i class="fa fa-th"></i> Modalidades <small>listando</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
        <div class="row">
            <div class="col-md-8">
                <a href="<?=base_url('admin/modalidade/adicionar');?>" class="btn btn-primary"><i class="fa fa-plus"></i> Adicionar</a>
            </div><!--col-md-8-->
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-search"></i>
                    </div>
                    <input class="form-control" id="buscar" name="buscar" placeholder="Buscar Nome da Modalidade" type="text">
                </div>                
            </div><!--col-md-4-->
        </div><!--row-->
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Modalidades</th>
                            <th colspan="2">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="lista_tbody">
                        <?php foreach ($lista->result() as $modalidade){?>
                        <tr>
                            <td><?= $modalidade->nome_modalidade;?></td>
                            <td style="width: 5%;text-align: center;"><a href="<?= base_url('admin/modalidade/editar/'.$modalidade->id_modalidade);?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Editar</a></td>
                            <td style="width: 5%;text-align: center;"><a href="<?= base_url('admin/modalidade/confirm-delete/'.$modalidade->id_modalidade);?>" class="btn btn-warning btn-xs"><i class="fa fa-trash-o"></i> Excluir</a></td>
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