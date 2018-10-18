  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><i class="fa fa-th-large"></i> Categorias <small>listando</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
            <a href="<?=base_url('admin/categoria/adicionar');?>" class="btn btn-primary"><i class="fa fa-plus"></i> Adicionar</a>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Categoria</th>
                            <th colspan="2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lista->result() as $categoria){?>
                        <tr>
                            <td><?= $categoria->nome_categoria;?></td>
                            <td style="width: 5%;text-align: center;"><a href="<?= base_url('admin/categoria/editar/'.$categoria->id_categoria);?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Editar</a></td>
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