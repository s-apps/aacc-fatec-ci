  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><i class="fa fa-university"></i> Cursos <small>listando</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
            <a href="<?=base_url('admin/curso/adicionar');?>" class="btn btn-primary"><i class="fa fa-plus"></i> Adicionar</a>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Cursos</th>
                            <th colspan="2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lista->result() as $curso){?>
                        <tr>
                            <td><?= $curso->nome_curso;?></td>
                            <td style="width: 5%;text-align: center;"><a href="<?= base_url('admin/curso/editar/'.$curso->id_curso);?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Editar</a></td>
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