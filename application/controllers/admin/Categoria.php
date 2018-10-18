<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends CI_Controller {
    
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
        $this->load->model('mod_categoria','mod_categoria');
    }

    public function lista()
    {
        $config['base_url'] = base_url() . 'admin/categoria/lista/';
        $config['total_rows'] = $this->mod_categoria->num_rows();
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
        $data['lista'] = $this->mod_categoria->getAll($config['per_page'],$config['per_page']*($page-1));
        $data['paginacao'] = $this->pagination->create_links();
        
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/categoria',$data);
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }
    
    public function adicionar()
    {
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/add_categoria');
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }

    public function editar($id_categoria)
    {
        $data['categoria'] = $this->mod_categoria->getByID($id_categoria);
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/edt_categoria',$data);
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }
    
    public function inserir()
    {
        $this->form_validation->set_rules('nome_categoria', 'Categoria', 'required');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/add_categoria');
            $this->load->view('tpl/footer');
            $this->load->view('tpl/scripts');
        }else{
            $nome_categoria = $this->input->post('nome_categoria');
            if($this->mod_categoria->inserir($nome_categoria)){
                redirect('admin/categoria/lista');
            }else{
                $data['erro'] = 'Ocorreu um erro inserindo na tabela categoria';
                $data['link'] = base_url('admin/categoria/adicionar');
                $this->load->view('tpl/header');
                $this->load->view('tpl/aside');
                $this->load->view('erro',$data);
                $this->load->view('tpl/footer');
                $this->load->view('tpl/scripts');
            }
        }
    }
    
    public function atualizar(){
        $this->form_validation->set_rules('nome_categoria', 'Categoria', 'required');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $data['categoria'] = $this->mod_categoria->getByID($this->input->post('id_categoria'));
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/edt_categoria',$data);
            $this->load->view('tpl/footer');
            $this->load->view('tpl/scripts');
        }else{
            $dados = ['nome_categoria'=>$this->input->post('nome_categoria'),'id_categoria'=>$this->input->post('id_categoria')];
            if($this->mod_categoria->atualizar($dados)){
                redirect('admin/categoria/lista');
            }else{
                $data['erro'] = 'Ocorreu um erro atualizando na tabela categoria';
                $data['link'] = base_url('admin/categoria/editar/'.$this->input->post('id_categoria'));
                $this->load->view('tpl/header');
                $this->load->view('tpl/aside');
                $this->load->view('erro',$data);
                $this->load->view('tpl/footer');
                $this->load->view('tpl/scripts');
            }
        }
    }

    public function addCategoriaExtra()
    {
        $data['sucesso'] = false;
        if($this->input->post('categoriaExtra')==''){
            $data['erro'] = 'O campo <strong>Categoria</strong> é requerido.';
        }else{
            if($this->mod_categoria->getByNomeCategoria($this->input->post('categoriaExtra'))){
                $data['erro'] = 'Categoria já existe.';
            }else{
                if($this->mod_categoria->inserir($this->input->post('categoriaExtra'))){
                    $data['id_categoria'] = $this->db->insert_id();
                    $data['nome_categoria'] = $this->input->post('categoriaExtra');
                    $data['sucesso'] = true;
                }else{
                    $data['erro'] = 'Ocorreu um erro inserindo na tabela Categoria';
                }
            }
        }
        echo json_encode($data);
    }
    
}
