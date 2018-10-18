<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Administrador extends CI_Controller {
    
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
        $this->load->model('mod_administrador','mod_administrador');
    }

    public function lista()
    {
        $config['base_url'] = base_url() . 'admin/administrador/lista/';
        $config['total_rows'] = $this->mod_administrador->num_rows();
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
        $data['lista'] = $this->mod_administrador->getAll($config['per_page'],$config['per_page']*($page-1));
        $data['paginacao'] = $this->pagination->create_links();
        
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/administrador',$data);
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }
    
    public function adicionar()
    {
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/add_administrador');
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }
    
    public function inserir()
    {
        $this->form_validation->set_rules('nome_administrador', 'Nome completo', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('senha', 'Senha', 'required');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/add_administrador');
            $this->load->view('tpl/footer');
            $this->load->view('tpl/scripts');
        }else{
            $dados = ['nome_administrador'=>mb_strtoupper($this->input->post('nome_administrador'),'UTF-8'),'email'=>$this->input->post('email'),'senha'=>md5($this->input->post('senha'))];
            if($this->mod_administrador->inserir($dados)){
                redirect('admin/administrador/lista');
            }else{
                $data['erro'] = 'Ocorreu um erro inserindo na tabela administrador';
                $data['link'] = base_url('admin/administrador/adicionar');
                $this->load->view('tpl/header');
                $this->load->view('tpl/aside');
                $this->load->view('erro',$data);
                $this->load->view('tpl/footer');
                $this->load->view('tpl/scripts');
            }
        }
    }
    
    public function editar($id_administrador)
    {
        $data['administrador'] = $this->mod_administrador->getByID($id_administrador);
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/edt_administrador',$data);
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }
    
    public function atualizar()
    {
        $this->form_validation->set_rules('nome_administrador', 'Nome completo', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/edt_administrador');
            $this->load->view('tpl/footer');
            $this->load->view('tpl/scripts');
        }else{
            $senha = ($this->input->post('senha') <> '' ? md5($this->input->post('senha')) : null) ;
            $dados = ['nome_administrador'=>mb_strtoupper($this->input->post('nome_administrador'),'UTF-8'),'email'=>$this->input->post('email'),'senha'=>$senha,'id_administrador'=>$this->input->post('id_administrador')];
            if($this->mod_administrador->atualizar($dados)){
                redirect('admin/administrador/lista');
            }else{
                $data['erro'] = 'Ocorreu um erro atualizando na tabela administrador';
                $data['link'] = base_url('admin/administrador/editar/'.$this->input->post('id_administrador'));
                $this->load->view('tpl/header');
                $this->load->view('tpl/aside');
                $this->load->view('erro',$data);
                $this->load->view('tpl/footer');
                $this->load->view('tpl/scripts');
            }
        }
    }
    
    public function confirm_delete($id_administrador)
    {
        $dados = ['chave_primaria'=>$id_administrador,'from'=>'administrador','link'=>'admin/administrador/lista'];
        $data['dados'] = $dados;
        $administrador = $this->mod_administrador->getByID($id_administrador);
        $html = '<p>Nome do Administrador: '.$administrador->nome_administrador.'</p>';
        $html .= '<p>Email: '.$administrador->email.'</p>';
        $data['html'] = $html;
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/confirm_delete',$data);
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }
    
    public function delete()
    {
        $this->mod_administrador->delete($this->input->post('chave_primaria'));
        redirect('admin/administrador/lista');
    }
    
}
