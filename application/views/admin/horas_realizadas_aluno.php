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
      <?php $atributos = array('id' => 'frmHorasRealizadasAluno', 'name' => 'frmHorasRealizadasAluno'); echo form_open('admin/relatorio/get_horas_realizadas_aluno', $atributos);?>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6 col-md-offset-0">

                    <div class="form-group">
                        <label for="ra_aluno">Aluno</label>
                        <div class="input-group">
                            <select class="form-control" id="ra_aluno" name="ra_aluno">
                                <option></option>
                                <?php foreach ($alunos as $aluno){?>
                                <option value="<?=$aluno->ra;?>"><?=$aluno->ra;?> | <?=$aluno->nome_aluno;?></option>
                                <?php }?>
                            </select>
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-flat" type="submit" id="btnRelatorio" data-loading-text="<i class='fa fa-spinner fa-spin '></i>">OK</button>
                            </div>
                        </div>
                    </div>

            </div><!--col-md-6-->
          </div><!--row-->
          <div id="resultado"></div>
        </div>
        <!-- /.box-body -->
        <?=form_close();?>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->