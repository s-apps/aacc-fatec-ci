<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comprovante extends CI_Controller {
    
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
        $this->load->model('mod_comprovante','mod_comprovante');
    }

    public function lista()
    {
        $config['base_url'] = base_url() . 'admin/comprovante/lista/';
        $config['total_rows'] = $this->mod_comprovante->num_rows();
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
        $data['lista'] = $this->mod_comprovante->getAll($config['per_page'],$config['per_page']*($page-1));
        $data['paginacao'] = $this->pagination->create_links();
        
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/comprovante',$data);
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }
    
    public function adicionar()
    {
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/add_comprovante');
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }

    public function editar($id_comprovante)
    {
        $data['comprovante'] = $this->mod_comprovante->getByID($id_comprovante);
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/edt_comprovante',$data);
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }
    
    public function inserir()
    {
        $this->form_validation->set_rules('nome_comprovante', 'Comprovante', 'required');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/add_comprovante');
            $this->load->view('tpl/footer');
            $this->load->view('tpl/scripts');
        }else{
            $nome_comprovante = $this->input->post('nome_comprovante');
            if($this->mod_comprovante->inserir($nome_comprovante)){
                redirect('admin/comprovante/lista');
            }else{
                $data['erro'] = 'Ocorreu um erro inserindo na tabela comprovante';
                $data['link'] = base_url('admin/comprovante/adicionar');
                $this->load->view('tpl/header');
                $this->load->view('tpl/aside');
                $this->load->view('erro',$data);
                $this->load->view('tpl/footer');
                $this->load->view('tpl/scripts');
            }
        }
    }
    
    public function atualizar(){
        $this->form_validation->set_rules('nome_comprovante', 'Comprovante', 'required');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $data['comprovante'] = $this->mod_comprovante->getByID($this->input->post('id_comprovante'));
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/edt_comprovante',$data);
            $this->load->view('tpl/footer');
            $this->load->view('tpl/scripts');
        }else{
            $dados = ['nome_comprovante'=>$this->input->post('nome_comprovante'),'id_comprovante'=>$this->input->post('id_comprovante')];
            if($this->mod_comprovante->atualizar($dados)){
                redirect('admin/comprovante/lista');
            }else{
                $data['erro'] = 'Ocorreu um erro atualizando na tabela comprovante';
                $data['link'] = base_url('admin/comprovante/editar/'.$this->input->post('id_comprovante'));
                $this->load->view('tpl/header');
                $this->load->view('tpl/aside');
                $this->load->view('erro',$data);
                $this->load->view('tpl/footer');
                $this->load->view('tpl/scripts');
            }
        }
    }

    public function addComprovanteExtra()
    {
        $data['sucesso'] = false;
        if($this->input->post('comprovanteExtra')==''){
            $data['erro'] = 'O campo <strong>Comprovante</strong> é requerido.';
        }else{
            if($this->mod_comprovante->getByNomeComprovante($this->input->post('comprovanteExtra'))){
                $data['erro'] = 'Comprovante já existe.';
            }else{
                if($this->mod_comprovante->inserir($this->input->post('comprovanteExtra'))){
                    $data['id_comprovante'] = $this->db->insert_id();
                    $data['nome_comprovante'] = $this->input->post('comprovanteExtra');
                    $data['sucesso'] = true;
                }else{
                    $data['erro'] = 'Ocorreu um erro inserindo na tabela Comprovante';
                }
            }
        }
        echo json_encode($data);
    }

    
}
