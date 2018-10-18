  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><i class="fa fa-graduation-cap"></i> Alunos <small>listando</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
        <div class="row">
            <div class="col-md-8">
                <a href="<?=base_url('admin/aluno/adicionar');?>" class="btn btn-primary"><i class="fa fa-plus"></i> Adicionar</a>
            </div><!--col-md-8-->
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-search"></i>
                    </div>
                    <input class="form-control" id="buscar" name="buscar" placeholder="Buscar por RA ou Nome do Aluno" type="text">
                </div>                
            </div><!--col-md-4-->
        </div><!--row-->
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>RA</th>
                            <th>Aluno</th>
                            <th>Email</th>
                            <th colspan="2">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="lista_tbody">
                        <?php foreach ($lista->result() as $aluno){?>
                        <tr>
                            <td><?= $aluno->ra;?></td>
                            <td><?= $aluno->nome_aluno;?></td>
                            <td><?= $aluno->email;?></td>
                            <td style="width: 5%;text-align: center;"><a href="<?= base_url('admin/aluno/editar/'.$aluno->ra);?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Editar</a></td>
                            <td style="width: 5%;text-align: center;"><a href="<?= base_url('admin/aluno/confirm-delete/'.$aluno->ra);?>" class="btn btn-warning btn-xs"><i class="fa fa-trash-o"></i> Excluir</a></td>
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