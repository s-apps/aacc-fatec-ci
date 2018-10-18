<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect('login');
        }else{
            if($this->session->userdata('nivel')!='aluno'){
                redirect('admin/dashboard');
            }
        }
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('mod_aluno','mod_aluno');
    }

    public function index()
    {
        $data['aluno'] = $this->mod_aluno->getByRA($this->session->userdata('id_usuario'));
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('aluno/perfil',$data);
        $this->load->view('tpl/footer');  
        $this->load->view('tpl/scripts');
    }
    
    public function atualizar()
    {
        $this->form_validation->set_rules('senha_antiga', 'Senha Antiga', 'required');
        $this->form_validation->set_rules('senha', 'Nova Senha', 'required');
        $this->form_validation->set_rules('senha_repeat', 'Repita a Nova Senha', 'required');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;margin:5px;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $this->index();
        }else{
            if($this->mod_aluno->senhaExiste($this->session->userdata('id_usuario'),md5($this->input->post('senha_antiga')))){
                if($this->input->post('senha')==$this->input->post('senha_repeat')){
                    if($this->mod_aluno->atualizarSenha($this->session->userdata('id_usuario'),md5($this->input->post('senha')))){
                        $data['mensagem'] = '<p style="color:#33cc33;font-weight:bold;">Senha alterada com sucesso</p>';
                    }else{
                        $data['mensagem'] = '<p style="color:#ff0000;font-weight:bold;">Ocorreu um erro alterando senha</p>';
                    }
                }else{
                    $data['mensagem'] = '<p style="color:#ff0000;font-weight:bold;">Senhas não coincidem</p>';
                }
            }else{
                $data['mensagem'] = '<p style="color:#ff0000;font-weight:bold;">Senha Antiga inválida</p>';
            }
            $data['aluno'] = $this->mod_aluno->getByRA($this->session->userdata('id_usuario'));
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('aluno/perfil',$data);
            $this->load->view('tpl/footer');  
            $this->load->view('tpl/scripts');
        }
    }
}
