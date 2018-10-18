<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Professor extends CI_Controller {
    
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
        $this->load->model('mod_professor','mod_professor');
        $this->load->model('mod_professor_leciona','mod_professor_leciona');
        $this->load->model('mod_curso','mod_curso');
    }

    public function lista()
    {
        $busca = $this->input->get('busca');
        if(isset($busca)){
            $html = '';
            $lista = $this->mod_professor->getAllByBusca($busca);
            foreach($lista as $professor){
                $html .= '<tr>
                <td>'.$professor->nome_professor.'</td>
                <td>'.$professor->email.'</td>
                <td style="width: 5%;text-align: center;"><a href="'.base_url('admin/professor/editar/'.$professor->id_professor).'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Editar</a></td>
                <td style="width: 5%;text-align: center;"><a href="'.base_url('admin/professor/confirm-delete/'.$professor->id_professor).'" class="btn btn-warning btn-xs btnExcluir" data-id_professor="'.$professor->id_professor.'"><i class="fa fa-trash-o"></i> Excluir</button></td>
            </tr>';
            }     
            $data['html'] = $html;
            echo json_encode($data);
        }else{
            $config['base_url'] = base_url() . 'admin/professor/lista/';
            $config['total_rows'] = $this->mod_professor->num_rows();
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
            $data['lista'] = $this->mod_professor->getAll($config['per_page'],$config['per_page']*($page-1));
            $data['paginacao'] = $this->pagination->create_links();
        
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/professor',$data);
            $this->load->view('tpl/footer');
            $data['newScript'] = '<script src="'. base_url('assets/js/aacc/professor.js'). '"></script>'.PHP_EOL;
            $this->load->view('tpl/scripts',$data);
        }
    }
    
    public function adicionar()
    {
        $data['cursos'] = $this->mod_curso->getAllSelect2();
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/add_professor',$data);
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }

    public function editar($id_professor)
    {

        $cursos = $this->mod_curso->getAllSelect2();
        $professor_leciona = '';
        $data['professor'] = $this->mod_professor->getByID($id_professor);
        foreach($cursos as $curso){
            $checked = ($this->mod_professor_leciona->curso($id_professor,$curso->id_curso))? $checked = ' checked="checked"' : '';
            $professor_leciona .= '
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="cursosleciona[]" value="'.$curso->id_curso.'"'.$checked.'>'.$curso->nome_curso.'
                </label>
            </div>';
        }
        $data['cursos'] = $cursos;
        $data['professor_leciona'] = $professor_leciona;
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/edt_professor',$data);
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }

    public function inserir()
    {
        $this->form_validation->set_rules('nome_professor', 'Nome completo', 'required');
        $this->form_validation->set_rules('email', 'Email', 'callback_email_existe');
        $this->form_validation->set_rules('senha', 'Senha', 'required');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $data['cursos'] = $this->mod_curso->getAllSelect2();
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/add_professor',$data);
            $this->load->view('tpl/footer');
            $this->load->view('tpl/scripts');
        }else{
            $dados = ['nome_professor'=>mb_strtoupper($this->input->post('nome_professor'),'UTF-8'),'email'=>$this->input->post('email'),'senha'=>md5($this->input->post('senha'))];
            if($this->mod_professor->inserir($dados)){
                $id_professor = $this->db->insert_id();
                if($this->input->post('cursosleciona') != null){
                    foreach ($this->input->post('cursosleciona') as $id_curso){
                        $dados = ['id_professor'=>$id_professor,'id_curso'=>$id_curso];
                        $this->mod_professor_leciona->inserir($dados);
                    }
                }
                redirect('admin/professor/lista');
            }else{
                $data['erro'] = 'Ocorreu um erro inserindo na tabela professor';
                $data['link'] = base_url('admin/professor/adicionar');
                $this->load->view('tpl/header');
                $this->load->view('tpl/aside');
                $this->load->view('erro',$data);
                $this->load->view('tpl/footer');
                $this->load->view('tpl/scripts');
            }
        }
    }

    public function atualizar()
    {
        $this->form_validation->set_rules('nome_professor', 'Nome completo', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $data['cursos'] = $this->mod_curso->getAllSelect2();
            $data['professor'] = $this->mod_professor->getByID($this->input->post('id_professor'));
            $data['professor_leciona'] = $this->mod_professor_leciona->getByID($this->input->post('id_professor'));
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/edt_professor',$data);
            $this->load->view('tpl/footer');
            $this->load->view('tpl/scripts');
        }else{
            $senha = ($this->input->post('senha') <> '' ? md5($this->input->post('senha')) : null) ;
            $dados = ['nome_professor'=>mb_strtoupper($this->input->post('nome_professor'),'UTF-8'),'email'=>$this->input->post('email'),'senha'=>$senha,'id_professor'=>$this->input->post('id_professor')];
            if($this->mod_professor->atualizar($dados)){
                $id_professor = $this->input->post('id_professor');
                $this->mod_professor_leciona->delete($id_professor);
                if($this->input->post('cursosleciona') != null){
                    foreach ($this->input->post('cursosleciona') as $id_curso){
                        $dados = ['id_professor'=>$id_professor,'id_curso'=>$id_curso];
                        $this->mod_professor_leciona->inserir($dados);
                    }
                }
                redirect('admin/professor/lista');
            }else{
                $data['erro'] = 'Ocorreu um erro atualizando na tabela professor';
                $data['link'] = base_url('admin/professor/editar/'.$this->input->post('id_professor'));
                $this->load->view('tpl/header');
                $this->load->view('tpl/aside');
                $this->load->view('erro',$data);
                $this->load->view('tpl/footer');
                $this->load->view('tpl/scripts');
            }
        }
    }
    
    public function email_existe($email)
    {
        if($email==''){
            $this->form_validation->set_message('email_existe', 'O campo <strong>Email</strong> é requerido');
            return FALSE;            
        }else{
            if($this->mod_professor->emailExiste($email)){
                $this->form_validation->set_message('email_existe', '<strong>Email</strong> já existe no banco de dados');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }

    public function confirm_delete($id_professor)
    {
        $dados = ['chave_primaria'=>$id_professor,'from'=>'professor','link'=>'admin/professor/lista'];
        $data['dados'] = $dados;
        $professor = $this->mod_professor->getByID($id_professor);
        $html = '<p>Nome do Professor: '.$professor->nome_professor.'</p>';
        $html .= '<p>Email: '.$professor->email.'</p>';
        $data['html'] = $html;
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/confirm_delete',$data);
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }
    
    public function delete()
    {
        $this->mod_professor->delete($this->input->post('chave_primaria'));
        $this->mod_professor->delete_professor_leciona($this->input->post('chave_primaria'));
        redirect('admin/professor/lista');
    }
    
    
}
