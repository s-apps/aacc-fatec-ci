  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
      
    <?php if($this->session->userdata('nivel')=='admin'){?>
      
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
          <li class="<?=($this->uri->segment(2)=='dashboard')?' active':'';?>">
          <a href="<?=base_url('admin/dashboard');?>">
            <i class="fa fa-dashboard"></i> <span>Painel de Controle</span>
          </a>
        </li>
        <li class="treeview<?=(($this->uri->segment(2)=='categoria')||($this->uri->segment(2)=='comprovante')||($this->uri->segment(2)=='modalidade')||($this->uri->segment(2)=='curso')||($this->uri->segment(2)=='administrador')||($this->uri->segment(2)=='aluno')||($this->uri->segment(2)=='professor'))?' active':'';?>">
          <a href="#">
            <span>Cadastros</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li<?=($this->uri->segment(2)=='categoria')?' class="active"':'';?>><a href="<?=base_url('admin/categoria/lista');?>"><i class="fa fa-th-large"></i> Categorias</a></li>
            <li<?=($this->uri->segment(2)=='comprovante')?' class="active"':'';?>><a href="<?=base_url('admin/comprovante/lista');?>"><i class="fa fa-certificate"></i> Comprovantes</a></li>
            <li<?=($this->uri->segment(2)=='modalidade')?' class="active"':'';?>><a href="<?=base_url('admin/modalidade/lista');?>"><i class="fa fa-th"></i> Modalidades</a></li>
            <li class="divider">-</li>
            <li<?=($this->uri->segment(2)=='administrador')?' class="active"':'';?>><a href="<?=base_url('admin/administrador/lista');?>"><i class="fa fa-id-badge"></i> Administradores</a></li>
            <li<?=($this->uri->segment(2)=='aluno')?' class="active"':'';?>><a href="<?=base_url('admin/aluno/lista');?>"><i class="fa fa-graduation-cap"></i> Alunos</a></li>
            <li<?=($this->uri->segment(2)=='curso')?' class="active"':'';?>><a href="<?=base_url('admin/curso/lista');?>"><i class="fa fa-university"></i> Cursos</a></li>
            <li<?=($this->uri->segment(2)=='professor')?' class="active"':'';?>><a href="<?=base_url('admin/professor/lista');?>"><i class="fa fa-group"></i> Professores</a></li>
          </ul>
        </li>   

        <li class="treeview<?=($this->uri->segment(2)=='atividade')?' active':'';?>">
          <a href="#">
            <span>Lançamentos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li<?=($this->uri->segment(2)=='atividade')?' class="active"':'';?>><a href="<?=base_url('admin/atividade/lista');?>"><i class="fa fa-cubes"></i> Atividades</a></li>
          </ul>
        </li>   

        <li class="treeview<?=($this->uri->segment(2)=='relatorio')?' active':'';?>">
          <a href="#">
            <span>Relatórios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li<?=($this->uri->segment(2)=='relatorio')?' class="active"':'';?>><a href="<?=base_url('admin/relatorio/horas-realizadas-aluno');?>"><i class="fa fa-clock-o"></i> Horas Realizadas Aluno</a></li>
          </ul>
        </li>

        <li><a href="<?=base_url('logout');?>"><i class="fa fa-sign-out"></i> Sair</a></li>
     </ul>
    </section>
    <!-- /.sidebar -->
      <?php }else{ ?>
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
          <li class="<?=($this->uri->segment(2)=='dashboard')?' active':'';?>">
          <a href="<?=base_url('aluno/dashboard');?>">
            <i class="fa fa-calendar"></i> <span>Avisos</span>
          </a>
        </li>
          <li class="<?=($this->uri->segment(2)=='atividade')?' active':'';?>">
          <a href="<?=base_url('aluno/atividade');?>">
            <i class="fa fa-cubes"></i> <span>Atividades</span>
          </a>
        </li>
          <li class="<?=($this->uri->segment(2)=='perfil')?' active':'';?>">
          <a href="<?=base_url('aluno/perfil');?>">
            <i class="fa fa-user"></i> <span>Dados Pessoais</span>
          </a>
        </li>
        <li><a href="<?=base_url('logout');?>"><i class="fa fa-sign-out"></i> Sair</a></li>
      </ul>
    </section>
      <?php }?>
  </aside>

  <!-- =============================================== -->
