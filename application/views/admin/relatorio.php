  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-clock-o"></i> Horas Realizadas Aluno</h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
      <?php $atributos = array('id' => 'frmHorasRealizadasAluno', 'name' => 'frmHorasRealizadasAluno'); echo form_open('admin/relatorio/getTotalHorasAluno', $atributos);?>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6 col-md-offset-0">
              <div class="form-group">
                <label for="ra_aluno">Aluno</label>
                  <select class="form-control" id="ra_aluno" name="ra_aluno">
                    <option></option>
                    <?php foreach($alunos->result() as $aluno){?>
                    <option value="<?=$aluno->ra;?>"<?=set_select('ra_aluno',$aluno->ra);?>><?=$aluno->ra;?> | <?=$aluno->nome_aluno;?></option>
                    <?php }?>
                  </select>
                  <?= form_error('ra_aluno'); ?>
              </div>
            </div><!--col-md-6-->
          </div><!--row-->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          Footer
        </div>
        <!-- /.box-footer-->
        <?=form_close();?>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->