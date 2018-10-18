<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect('login');
        }else{
            if($this->session->userdata('nivel')!='aluno'){
                redirect('admin/dashboard');
            }
        }
        $this->load->model('mod_dashboard','mod_dashboard');
    }

    public function index()
    {
        $avisos = $this->mod_dashboard->getAllAvisos();
        $html = '';
        foreach ($avisos as $aviso){
            $html .= '<tr><td>'.date('d/m/Y',strtotime($aviso->data_aviso)).'</td><td>'.$aviso->titulo_aviso.'</td><td>'.$aviso->aviso.'</td></tr>';
        }
        if(!isset($aviso)){
            $html .= '<p class="text-center">Nenhum aviso até o momento</p>';
        }
        $data['html'] = $html;
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('aluno/dashboard',$data);
        $this->load->view('tpl/footer');  
        $this->load->view('tpl/scripts');
    }
}
