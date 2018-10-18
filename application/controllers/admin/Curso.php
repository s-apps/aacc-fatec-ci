<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Curso extends CI_Controller {
    
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
        $this->load->model('mod_curso','mod_curso');
    }

    public function lista()
    {
        $config['base_url'] = base_url() . 'admin/curso/lista/';
        $config['total_rows'] = $this->mod_curso->num_rows();
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
        $data['lista'] = $this->mod_curso->getAll($config['per_page'],$config['per_page']*($page-1));
        $data['paginacao'] = $this->pagination->create_links();
        
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/curso',$data);
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }
    
    public function adicionar()
    {
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/add_curso');
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }
    
    public function inserir()
    {
        $this->form_validation->set_rules('nome_curso', 'Curso', 'required');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/add_curso');
            $this->load->view('tpl/footer');
            $this->load->view('tpl/scripts');
        }else{
            $nome_curso = $this->input->post('nome_curso');
            if($this->mod_curso->inserir($nome_curso)){
                redirect('admin/curso/lista');
            }else{
                $data['erro'] = 'Ocorreu um erro inserindo na tabela curso';
                $data['link'] = base_url('admin/curso/adicionar');
                $this->load->view('tpl/header');
                $this->load->view('tpl/aside');
                $this->load->view('erro',$data);
                $this->load->view('tpl/footer');
                $this->load->view('tpl/scripts');
            }
        }
    }
    
    public function editar($id_curso)
    {
        $data['curso'] = $this->mod_curso->getByID($id_curso);
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/edt_curso',$data);
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }
    
    public function atualizar(){
        $this->form_validation->set_rules('nome_curso', 'Curso', 'required');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $data['curso'] = $this->mod_curso->getByID($this->input->post('id_curso'));
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/edt_curso',$data);
            $this->load->view('tpl/footer');
            $this->load->view('tpl/scripts');
        }else{
            $dados = ['nome_curso'=>$this->input->post('nome_curso'),'id_curso'=>$this->input->post('id_curso')];
            if($this->mod_curso->atualizar($dados)){
                redirect('admin/curso/lista');
            }else{
                $data['erro'] = 'Ocorreu um erro atualizando na tabela curso';
                $data['link'] = base_url('admin/curso/editar/'.$this->input->post('id_curso'));
                $this->load->view('tpl/header');
                $this->load->view('tpl/aside');
                $this->load->view('erro',$data);
                $this->load->view('tpl/footer');
                $this->load->view('tpl/scripts');
            }
        }
    }
    
    
}
