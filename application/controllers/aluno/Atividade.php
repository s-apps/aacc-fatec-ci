<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Atividade extends CI_Controller {
    
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
        $this->load->model('mod_atividade','mod_atividade');
        $this->load->model('mod_modalidade','mod_modalidade');
    }

    public function index()
    {
        $ra_aluno = $this->session->userdata('id_usuario');
        $modalidades = $this->mod_modalidade->getAllLista();
        $config = $this->mod_dashboard->getConfig();
        $html = '';
        $horas = array();
        $minutos = 0;
        
        foreach ($modalidades as $modalidade){
            
            $atividades = $this->mod_atividade->getAllByModalidadeRA($modalidade->id_modalidade,$ra_aluno);
            
            if($atividades != null){
                $html .= '<div class="table-responsive">';
                $html .= '<table class="table table-bordered">';
                $html .= '<thead>';
                $html .= '<tr class="active">';
                $html .= '<th colspan="5">'.$modalidade->nome_modalidade.'</th>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<th style="width:10%;vertical-align : middle;">Data</th>';
                $html .= '<th style="vertical-align : middle;">Atividade</th>';
                $html .= '<th style="width:15%;vertical-align : middle;text-align: right;">Carga Horária</th>';
                $html .= '<th colspan="3"></th>';
                $html .= '</tr>';
                $html .= '</thead>';
                $html .= '<tbody>';
                foreach ($atividades as $atividade) {
                    $html .= '<tr>';
                    $html .= '<td>'.date('d/m/Y',strtotime($atividade->data_atividade)).'</td>';
                    $html .= '<td>'.$atividade->descricao_atividade.'</td>';
                    $html .= '<td style="text-align:right;">'.date('H:i',strtotime($atividade->carga_horaria)).'</td>';
                    $html .= '<td style="width:10%;text-align:center;"><button type="button" class="btn btn-primary btn-xs btnGerarCertificado" data-loading-text="Aguarde..."  data-id_atividade="'.$atividade->id_atividade.'"><i class="fa fa-print"></i> Certificado</button></td>';
                    $horas[] = $atividade->carga_horaria;
                }
                $html .= '</tbody>';
                $html .= '</table>';
                $html .= '</div>';
            }
        }

        foreach ($horas as $hora) {
            list($h, $m) = explode(':', $hora);
            $minutos += $h * 60;
            $minutos += $m;
        }
        $horas = floor($minutos / 60);
        $minutos -= $horas * 60;
        $total_horas = sprintf('%02d:%02d', $horas, $minutos);
        
        $data['total_horas'] = '<p style="text-align:center;font-weight:bold;">Total de Horas Realizadas: '.$total_horas.' - Limite: '.$config->limite_atividade.' Horas</p>';
        
        $data['html'] = $html;
        
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('aluno/atividade',$data);
        $this->load->view('tpl/footer');  
        $data['newScript'] = '<script src="'. base_url('assets/js/aacc/aluno.js'). '"></script>'.PHP_EOL;
        $this->load->view('tpl/scripts',$data);
    }
}
