<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Aluno extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect('login');
        }else{
            if($this->session->userdata('nivel')!='admin'){
                redirect('aluno/dashboard');
            }
        }
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('mod_aluno','mod_aluno');
        $this->load->model('mod_curso','mod_curso');
    }

    public function lista()
    {
        $busca = $this->input->get('busca');
        if(isset($busca)){
            $html = '';
            $lista = $this->mod_aluno->getAllByBusca($busca);
            foreach($lista as $aluno){
                $html .= '<tr>
                <td>'.$aluno->ra.'</td>
                <td>'.$aluno->nome_aluno.'</td>
                <td>'.$aluno->email.'</td>
                <td style="width: 5%;text-align: center;"><a href="'.base_url('admin/aluno/editar/'.$aluno->ra).'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Editar</a></td>
                <td style="width: 5%;text-align: center;"><a href="'.base_url('admin/aluno/confirm-delete/'.$aluno->ra).'" class="btn btn-warning btn-xs" data-ra="'.$aluno->ra.'"><i class="fa fa-trash-o"></i> Excluir</button></td>
            </tr>';
            }     
            $data['html'] = $html;
            echo json_encode($data);
        }else{
            $config['base_url'] = base_url() . 'admin/aluno/lista/';
            $config['total_rows'] = $this->mod_aluno->num_rows();
            $config['per_page'] = 10;
            $config['num_links'] = 2;
            $config['use_page_numbers'] = TRUE;
            $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
            $config['full_tag_close'] = '</ul>';
            $config['last_link'] = FALSE;
            $config['first_link'] = FALSE;
            $config['next_link'] = '<i class="fa fa-arrow-right"></i>';
            $config['next_tag_open'] = '<li class="next page">';
            $config['next_tag_close'] = '</li>';
            $config['prev_link'] = '<i class="fa fa-arrow-left"></i>';
            $config['prev_tag_open'] = '<li class="prev page">';
            $config['prev_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active"><a href="">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li class="page">';
            $config['num_tag_close'] = '</li>';
            $config['anchor_class'] = 'follow_link';        
            $this->pagination->initialize($config);
        
            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
            $data['lista'] = $this->mod_aluno->getAll($config['per_page'],$config['per_page']*($page-1));
            $data['paginacao'] = $this->pagination->create_links();
        
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/aluno',$data);
            $this->load->view('tpl/footer');
            $data['newScript'] = '<script src="'. base_url('assets/js/aacc/aluno.js'). '"></script>'.PHP_EOL;
            $this->load->view('tpl/scripts',$data);
        }
    }
    
    public function adicionar()
    {
        $data['cursos'] = $this->mod_curso->getAllSelect2();
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/add_aluno',$data);
        $this->load->view('tpl/footer');
        $data['newScript'] = '<script src="'. base_url('assets/js/select2/js/select2.min.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/i18n/pt-BR.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/aacc/aluno.js'). '"></script>'.PHP_EOL;
        $this->load->view('tpl/scripts',$data);
    }

    public function editar($ra)
    {
        $data['cursos'] = $this->mod_curso->getAllSelect2();
        $data['aluno'] = $this->mod_aluno->getByRA($ra);
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/edt_aluno',$data);
        $this->load->view('tpl/footer');
        $data['newScript'] = '<script src="'. base_url('assets/js/select2/js/select2.min.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/i18n/pt-BR.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/aacc/aluno.js'). '"></script>'.PHP_EOL;
        $this->load->view('tpl/scripts',$data);
    }

    
    public function inserir()
    {
        $this->form_validation->set_rules('ra', 'RA', 'callback_ra_existe');
        $this->form_validation->set_rules('nome_aluno', 'Nome completo', 'required');
        $this->form_validation->set_rules('email', 'Email', 'callback_email_existe');
        $this->form_validation->set_rules('senha', 'Senha', 'required');
        $this->form_validation->set_rules('id_curso', 'Curso', 'required');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/add_aluno');
            $this->load->view('tpl/footer');
            $data['newScript'] = '<script src="'. base_url('assets/js/select2/js/select2.min.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/i18n/pt-BR.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/aacc/aluno.js'). '"></script>'.PHP_EOL;
            $this->load->view('tpl/scripts',$data);
        }else{
            $dados = ['ra'=>$this->input->post('ra'),'nome_aluno'=>mb_strtoupper($this->input->post('nome_aluno'),'UTF-8'),'email'=>$this->input->post('email'),'senha'=>md5($this->input->post('senha')),'id_curso'=>$this->input->post('id_curso')];
            if($this->mod_aluno->inserir($dados)){
                redirect('admin/aluno/lista');
            }else{
                $data['erro'] = 'Ocorreu um erro inserindo na tabela aluno';
                $data['link'] = base_url('admin/aluno/adicionar');
                $this->load->view('tpl/header');
                $this->load->view('tpl/aside');
                $this->load->view('erro',$data);
                $this->load->view('tpl/footer');
                $this->load->view('tpl/scripts');
            }
        }
    }
    
    public function ra_existe($ra)
    {
        if($ra==''){
            $this->form_validation->set_message('ra_existe', 'O campo <strong>RA</strong> é requerido');
            return FALSE;            
        }else{
            if($this->mod_aluno->raExiste($ra)){
                $this->form_validation->set_message('ra_existe', '<strong>RA</strong> já existe no banco de dados');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    
    public function email_existe($email)
    {
        if($email==''){
            $this->form_validation->set_message('email_existe', 'O campo <strong>Email</strong> é requerido');
            return FALSE;            
        }else{
            if($this->mod_aluno->emailExiste($email)){
                $this->form_validation->set_message('email_existe', '<strong>Email</strong> já existe no banco de dados');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }

    public function atualizar()
    {
        $this->form_validation->set_rules('ra', 'RA', 'required');
        $this->form_validation->set_rules('nome_aluno', 'Nome completo', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('id_curso', 'Curso', 'required');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $data['cursos'] = $this->mod_curso->getAllSelect2();
            $data['aluno'] = $this->mod_aluno->getByRA($this->input->post('ra'));
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/edt_aluno',$data);
            $this->load->view('tpl/footer');
            $data['newScript'] = '<script src="'. base_url('assets/js/select2/js/select2.min.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/i18n/pt-BR.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/aacc/aluno.js'). '"></script>'.PHP_EOL;
            $this->load->view('tpl/scripts',$data);
        }else{
            $senha = ($this->input->post('senha') <> '' ? md5($this->input->post('senha')) : null) ;
            $dados = ['nome_aluno'=>mb_strtoupper($this->input->post('nome_aluno'),'UTF-8'),'email'=>$this->input->post('email'),'senha'=>$senha,'id_curso'=>$this->input->post('id_curso'),'ra'=>$this->input->post('ra')];
            if($this->mod_aluno->atualizar($dados)){
                redirect('admin/aluno/lista');
            }else{
                $data['erro'] = 'Ocorreu um erro atualizando na tabela aluno';
                $data['link'] = base_url('admin/aluno/editar/'.$this->input->post('ra'));
                $this->load->view('tpl/header');
                $this->load->view('tpl/aside');
                $this->load->view('erro',$data);
                $this->load->view('tpl/footer');
                $this->load->view('tpl/scripts');
            }
        }
    }

    public function confirm_delete($ra_aluno)
    {
        $dados = ['chave_primaria'=>$ra_aluno,'from'=>'aluno','link'=>'admin/aluno/lista'];
        $data['dados'] = $dados;
        $aluno = $this->mod_aluno->getByRA($ra_aluno);
        $html = '<p>RA: '.$aluno->ra.'</p>';
        $html .= '<p>Nome do Aluno: '.$aluno->nome_aluno.'</p>';
        $html .= '<p>Email: '.$aluno->email.'</p>';
        $html .= '<p>Atividades Relacionadas: (<strong>'.$this->mod_aluno->countAtividades($ra_aluno).'</strong>) Atividades Relacionadas também serão excluídas.</p>';
        $data['html'] = $html;
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/confirm_delete',$data);
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }
    
    public function delete()
    {
        $this->mod_aluno->delete($this->input->post('chave_primaria'));
        $this->mod_aluno->delete_atividades($this->input->post('chave_primaria'));
        $this->mod_aluno->delete_atividades_tem_certificado($this->input->post('chave_primaria'));
        redirect('admin/aluno/lista');
    }
    
    
}
