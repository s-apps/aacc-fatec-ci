<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio extends CI_Controller {
    
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
        $this->load->model('mod_aluno','mod_aluno');
        $this->load->model('mod_atividade','mod_atividade');
    }

    public function horas_realizadas_aluno()
    {
        $data['alunos'] = $this->mod_aluno->getAllSelect2();
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/horas_realizadas_aluno',$data);
        $this->load->view('tpl/footer');
        $data['newScript'] = '<script src="'. base_url('assets/js/select2/js/select2.min.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/i18n/pt-BR.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/aacc/relatorio.js'). '"></script>'.PHP_EOL;
        $this->load->view('tpl/scripts',$data);
    }

    public function get_horas_realizadas_aluno()
    {
        $data['sucesso'] = false;
        if($this->input->post('ra_aluno')==null){
            $data['mensagem'] = '<p style="text-align:center;color:#ff0000;">Selecione o Aluno</p>';
        }else{
            $atividades = $this->mod_atividade->getAllByRA($this->input->post('ra_aluno'));
            if($atividades!=null){
                $data['sucesso'] = true;    
                $html = '
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Atividade</th>
                                <th>Carga Horária</th>
                            </tr>
                        </thead>
                    <tbody>
                 ';

                $horas = array();
                $minutos = 0;

                foreach ($atividades as $atividade) {
                    $html .= '
                    <tr>
                        <td>'.date('d/m/Y',strtotime($atividade->data_atividade)).'</td>
                        <td>'.$atividade->descricao_atividade.'</td>
                        <td>'.date('H:i',strtotime($atividade->carga_horaria)).'</td>
                    </tr>            
                    ';
                    $horas[] = $atividade->carga_horaria;
                }
                foreach ($horas as $hora) {
                    list($h, $m) = explode(':', $hora);
                    $minutos += $h * 60;
                    $minutos += $m;
                }
                $horas = floor($minutos / 60);
                $minutos -= $horas * 60;
                $total_horas = sprintf('%02d:%02d', $horas, $minutos);
                $html .= '<tr><td colspan="2" style="text-align:right;"><strong>Total de Horas Realizadas:</strong></td><td><strong>'.$total_horas.'</strong></td></tr>';
                $html .= '
                        </tbody>
                    </table>            
                </div>        
                ';
                $data['html'] = $html;
            }else{
                $data['mensagem'] = '<p style="text-align:center;">Nenhuma Atividade Realizada: <strong>RA '.$this->input->post('ra_aluno').'</strong></p>';
            }
        }
        echo json_encode($data);
    }
}
