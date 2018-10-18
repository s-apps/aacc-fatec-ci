<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct(){
        parent::__construct();
        if($this->session->userdata('logged_in')){
            if($this->session->userdata('nivel')=='admin'){
                redirect('admin/dashboard');
            }else{
                redirect('aluno/dashboard');
            }
        }
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('mod_administrador','mod_administrador');
        $this->load->model('mod_aluno','mod_aluno');
    }
    
    public function index()
    {
        $this->load->view('login');
    }
    
    public function entrar()
    {
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('senha', 'Senha', 'required');
        $this->form_validation->set_rules('nivel','Nível','required');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;margin:5px;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $this->load->view('login');
        }else{
            $email = $this->input->post('email');
            $senha = md5($this->input->post('senha'));
            $nivel = $this->input->post('nivel');
            $existe = false;
            switch ($nivel){
                case 'admin':
                    $administrador = $this->mod_administrador->existe($email,$senha);
                    if($administrador!=null){
                        $session = ['logged_in'=>true,'id_usuario'=>$administrador->id_administrador,'nome_usuario'=>$administrador->nome_administrador,'nivel'=>'admin'];
                        $existe = true;
                    }
                break;
                case 'aluno':
                    $aluno = $this->mod_aluno->existe($email,$senha);
                    if($aluno!=null){
                        $session = ['logged_in'=>true,'id_usuario'=>$aluno->ra,'nome_usuario'=>$aluno->nome_aluno,'nivel'=>'aluno'];
                        $existe = true;
                    }
                break;    
            }
            
            if($existe){
                $this->session->set_userdata($session);
                if($nivel=='admin'){
                    redirect('admin/dashboard');
                }else{
                    redirect('aluno/dashboard');
                }
            }else{
                $data['erro'] = '<i class="fa fa-warning"></i> Email ou Senha inválidos';
                $this->load->view('login',$data);
            }
            
        }
        
    }
    
    public function recovery()
    {
        $this->load->view('login_recovery');
    }
    
    public function recover()
    {
        $this->load->helper('string');
        $this->load->library('email');
        $enviaremail = false;
        $data = array();
        
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;margin:5px;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $this->recovery();
        }else{
            $nivel = $this->input->post('nivel');
            $email = $this->input->post('email');
                        
            switch ($nivel){
                case 'admin':
                    if($this->mod_administrador->emailExiste($email)){
                        $enviaremail = true;
                    }
                break;
                case 'aluno':
                    if($this->mod_aluno->emailExiste($email)){
                        $enviaremail = true;
                    }
                break;    
            }
            if($enviaremail){
                $novaSenha = strtolower(random_string('alnum', 4));
                $config['smtp_host'] = getenv('EMAIL_HOST');
                $config['smtp_user'] = getenv('EMAIL_USER');
                $config['smtp_pass'] = getenv('EMAIL_PASS');
                $config['smtp_port'] = getenv('EMAIL_PORT');
                $config['protocol'] = 'smtp';
                $config['mailtype'] = 'html';
                $config['wordwrap'] = TRUE;
                $config['charset'] = 'utf-8';
                $this->email->initialize($config);
                $this->email->from(getenv('EMAIL_FROM'), 'AACC - Fatec');
                $this->email->to($email); 
                $this->email->subject('AACC - Fatec - Acesso');
                $mensagem = 'Olá! <br/>Sua Nova Senha: '.$novaSenha.'<br/>Para confirmar, acesse: '.base_url('login/recovering/'.$nivel);  
                $this->email->message($mensagem);
                if($this->email->send()){
                    if($nivel=='admin'){
                        $this->mod_administrador->updateSenhaTemporaria($email,md5($novaSenha));
                    }else{
                        $this->mod_aluno->updateSenhaTemporaria($email,md5($novaSenha));
                    }
                    $data['mensagem'] = '<p style="color:#33cc33;">Senha enviada com sucesso</p>';
                    $this->load->view('login_recovery',$data);
                }else{
                    $data['mensagem'] = '<p style="color:#ff0000;">Erro! Tente novamente mais tarde</p>';
                }
            }else{
                $data['mensagem'] = '<p style="color:#ff0000;">Erro! Tente novamente mais tarde</p>';
            }
        }
        $this->load->view('login_recovery',$data);
    }
    
    public function recovering($nivel)
    {
        if(isset($nivel)){
            if(($nivel=='admin')||($nivel=='aluno')){
                $data['nivel'] = $nivel;
                $this->load->view('recovering',$data);
            }else{
                redirect('login');
            }
        }else{
            redirect('login');
        }
    }
    
    public function confirm_recovered()
    {
        $recuperado = false;
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('senha','Senha','required');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;margin:5px;text-align:center;"><i class="fa fa-warning"></i> ', '</div>');
        if($this->form_validation->run() == FALSE){
            $data['nivel'] = $this->input->post('nivel');
            $this->load->view('recovering',$data);
        }else{
            if($this->input->post('nivel')=='admin'){
                if($this->mod_administrador->senhaTempExiste($this->input->post('email'),md5($this->input->post('senha')))){
                    if($this->mod_administrador->updateSenha($this->input->post('email'),md5($this->input->post('senha')))){
                        $recuperado = true;
                    }
                }
            }else{
                if($this->mod_aluno->senhaTempExiste($this->input->post('email'),md5($this->input->post('senha')))){
                    if($this->mod_aluno->updateSenha($this->input->post('email'),md5($this->input->post('senha')))){
                        $recuperado = true;
                    }
                }
            }
            redirect('login');
        }
    }
    
}
