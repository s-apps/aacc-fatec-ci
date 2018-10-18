  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><i class="fa fa-id-badge"></i> Administradores <small>listando</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
            <a href="<?=base_url('admin/administrador/adicionar');?>" class="btn btn-primary"><i class="fa fa-plus"></i> Adicionar</a>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Administrador</th>
                            <th>Email</th>
                            <th colspan="2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lista->result() as $administrador){?>
                        <tr>
                            <td><?= $administrador->nome_administrador;?></td>
                            <td><?= $administrador->email;?></td>
                            <td style="width: 5%;text-align: center;"><a href="<?= base_url('admin/administrador/editar/'.$administrador->id_administrador);?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Editar</a></td>
                            <td style="width: 5%;text-align: center;"><a class="btn btn-warning btn-xs" href="<?=base_url('admin/administrador/confirm-delete/'.$administrador->id_administrador);?>"><i class="fa fa-trash-o"></i> Excluir</a></td>
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