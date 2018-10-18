<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Aviso extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect('login');
        }else{
            if($this->session->userdata('nivel')!='admin'){
                redirect('aluno/dashboard');
            }
        }
    }

    public function index()
    {
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/dashboard');
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }
}
