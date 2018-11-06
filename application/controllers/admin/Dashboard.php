<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
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
        $this->load->model('mod_dashboard','mod_dashboard');
    }

    public function index()
    {
        $data['config'] = $this->mod_dashboard->getConfig();
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/dashboard',$data);
        $this->load->view('tpl/footer');
        $data['newScript'] = '<script src="'. base_url('assets/js/jquery.inputmask.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/jquery.inputmask.date.extensions.js').'"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/jquery.inputmask.extensions.js').'"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/aacc/dashboard.js'). '"></script>'.PHP_EOL;
        $this->load->view('tpl/scripts',$data);
    }

    public function add_aviso()
    {
        $data['data_aviso'] = date('d/m/Y');
        echo json_encode($data);
    }

    public function salvar_aviso()
    {
        $data['sucesso'] = false;
        $data_aviso = $this->mod_dashboard->converterData($this->input->get('data_aviso'));
        $titulo_aviso = $this->input->get('titulo_aviso');
        $aviso = $this->input->get('aviso');

        if(($data_aviso==null)||($titulo_aviso==null)||($aviso==null)){
            $data['mensagem'] = '<span style="color:#ff0000;"><i class="fa fa-warning"></i> Informe todos os campos</span>';
        }else{
            $dados = ['data_aviso'=>$data_aviso,'titulo_aviso'=>$titulo_aviso,'aviso'=>$aviso];
            if($this->mod_dashboard->inserirAviso($dados)){
                $data['sucesso'] = true;
                $data['mensagem'] = '<span style="color:#33cc33;"><i class="fa fa-info"></i> Adicionado com sucesso!</span>';
            }else{
                $data['mensagem'] = '<span style="color:#ff0000;"><i class="fa fa-warning"></i> Erro inserindo aviso</span>';
            }
        }
        echo json_encode($data);
        
    }

    public function carrega_avisos()
    {
        $avisos = $this->mod_dashboard->getAllAvisos();
        $html = '';
        foreach($avisos as $aviso){
        $html .= '
            <div class="panel box">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-10">
                            <a data-toggle="collapse" data-parent="#accordion" href="#'.$aviso->id.'">
                            '.date('d/m/Y',strtotime($aviso->data_aviso)).'<br/>'.$aviso->titulo_aviso.'
                            </a>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-default btn-xs" id="btnExcluirAviso" data-id_aviso="'.$aviso->id.'"><i class="fa fa-trash-o"></i> Excluir</button>
                        </div>
                    </div>
                </div>
                <div id="'.$aviso->id.'" class="panel-collapse collapse">
                    <div class="box-body">
                        '.$aviso->aviso.'
                    </div>
                </div>
            </div>
        ';
        }
        $data['html']  = $html;
        echo json_encode($data);   
    }
    
    public function carrega_config()
    {
        $config = $this->mod_dashboard->getConfig();
        $data['nome_diretor'] = $config->nome_diretor;
        $data['assinatura'] = $config->assinatura;
        echo json_encode($data);
    }

    public function excluir_aviso()
    {
        $data['sucesso'] = false;
        if($this->mod_dashboard->delete($this->input->get('id_aviso'))){
            $data['sucesso'] = true;
        }else{
            $data['mensagemAviso'] = 'Não foi possível excluir';
        }
        echo json_encode($data);
    }

    public function backup()
    {
        /*$prefs = array(
        'format'        => 'txt',                       // gzip, zip, txt
        'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
        'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
        'newline'       => "\n"                         // Newline character used in backup file
        );  
        
        // Load the DB utility class
        $this->load->dbutil();

        // Backup your entire database and assign it to a variable
        $backup = $this->dbutil->backup($prefs);

        // Load the file helper and write the file to your server
        $this->load->helper('file');
        write_file('./assets/backup/Backup_AACC_'.date('d.m.Y').'.sql', $backup);

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download('Backup_AACC_'.date('d.m.Y').'.sql', $backup);    
        //redirect('admin/dashboard');
         * 
         */
    }

    public function config_update()
    {
        $this->form_validation->set_rules('nome_diretor', 'Nome do Diretor(a)', 'required');
        $this->form_validation->set_rules('limite_atividade', 'Limite Atividades', 'required');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;margin:5px;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $data['config'] = $this->mod_dashboard->getConfig();
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/dashboard',$data);
            $this->load->view('tpl/footer');
            $data['newScript'] = '<script src="'. base_url('assets/js/jquery.inputmask.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/jquery.inputmask.date.extensions.js').'"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/jquery.inputmask.extensions.js').'"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/aacc/dashboard.js'). '"></script>'.PHP_EOL;
            $this->load->view('tpl/scripts',$data);
        }else{
            $assinatura = '';
            $config['upload_path'] = './assets/img/assinatura';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if($this->upload->do_upload('assinatura')){
                $assinatura = $this->upload->data('file_name');
            }
            $dados = ['assinatura'=>$assinatura,'nome_diretor'=>$this->input->post('nome_diretor'),'limite_atividade'=>$this->input->post('limite_atividade'),'id'=>'default'];
            $this->mod_dashboard->updateConfig($dados);
            redirect('admin/dashboard');
        }
    }
}
