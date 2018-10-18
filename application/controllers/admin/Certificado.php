<?php

defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set("America/Sao_Paulo");
setlocale(LC_TIME, 'pt_BR','pt_BR.utf-8','pt_BR.utf-8','portuguese');

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

class Certificado extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect('login');
        }
        $this->load->helper('file');
        $this->load->model('mod_aluno','mod_aluno');
        $this->load->model('mod_atividade','mod_atividade');
        $this->load->model('mod_certificado','mod_certificado');
        $this->load->model('mod_dashboard','mod_dashboard');
    }

    public function prever()
    {
        
        $modeloCertificado = $this->input->get('modeloCertificado');

        if($modeloCertificado==null){
            $data['sucesso'] = false;
        }else{    
            $data_atividade = $this->mod_atividade->converterData($this->input->get('data_atividade'));
            $data_atividade_extenso = utf8_encode(strftime('%d de %B de %Y',strtotime($data_atividade)));
            $data_hoje = utf8_encode(strftime('%d de %B de %Y', strtotime('today')));
            $carga_horaria = $this->input->get('carga_horaria');
            $descricao_atividade = $this->input->get('descricao_atividade');
            $ra_aluno = $this->input->get('ra_aluno');
            $nome_aluno = ($ra_aluno!=null)?$this->mod_aluno->getNome($ra_aluno):'Nome do Aluno não informado';
            $id_modalidade = $this->input->get('id_modalidade');
            $base_url = base_url();
            $config = $this->mod_dashboard->getAll();
            $assinatura = $config->assinatura;
            $nome_diretor = $config->nome_diretor;


            $loader = new Twig_Loader_Filesystem('./assets/certificados/modelos');
            $twig = new Twig_Environment($loader);
            $template = $twig->load('tpl.'.$modeloCertificado.'.php');

            switch ($modeloCertificado) {
                case 'apoio':
                    $evento = $this->input->get('evento');
                    $periodo = $this->input->get('periodo');
                    $certificado = $template->render(array('base_url' => $base_url, 'data_atividade' => $data_atividade_extenso, 'carga_horaria' => $carga_horaria, 'nome_aluno' => $nome_aluno, 'evento' => $evento, 'periodo' => $periodo,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
                break;
                case 'apresentacao_de_trab':
                    $nome_trabalho = $this->input->get('nome_trabalho');
                    $local_apresentacao = $this->input->get('local_apresentacao');
                    $certificado = $template->render(array('base_url'=>$base_url,'data_atividade'=>$data_atividade_extenso,'nome_aluno'=>$nome_aluno,'nome_trabalho'=>$nome_trabalho,'local_apresentacao'=>$local_apresentacao,'data_hoje'=>$data_hoje,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
                break;
                case 'banca':
                    $titulo_monografia = $this->input->get('titulo_monografia');
                    $subtitulo_monografia = $this->input->get('subtitulo_monografia');
                    $nome_completo_orientando = $this->input->get('nome_completo_orientando');
                    $do_curso_superior_de = $this->input->get('do_curso_superior_de');
                    $certificado = $template->render(array('base_url'=>$base_url,'data_atividade'=>$data_atividade_extenso,'nome_aluno'=>$nome_aluno,'titulo_monografia'=>$titulo_monografia,'subtitulo_monografia'=>$subtitulo_monografia,'nome_completo_orientando'=>$nome_completo_orientando,'do_curso_superior_de'=>$do_curso_superior_de,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
                break;
                case 'evento':
                    $nome_evento = $this->input->get('nome_evento');
                    $promovido_por = $this->input->get('promovido_por');
                    $certificado = $template->render(array('base_url'=>$base_url,'data_atividade'=>$data_atividade_extenso,'nome_aluno'=>$nome_aluno,'nome_evento'=>$nome_evento,'promovido_por'=>$promovido_por,'data_hoje'=>$data_hoje,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
                break;
                case 'expositor':
                    $nome_exposicao = $this->input->get('nome_exposicao');
                    $ra_aluno = ($ra_aluno!=null)?$ra_aluno:'RA não informado';
                    $periodo_exposicao = $this->input->get('periodo_exposicao');
                    $certificado = $template->render(array('base_url'=>$base_url,'ra'=>$ra_aluno,'nome_aluno'=>$nome_aluno,'nome_exposicao'=>$nome_exposicao,'periodo_exposicao'=>$periodo_exposicao,'carga_horaria'=>$carga_horaria,'data_hoje'=>$data_hoje,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
                break;
                case 'minicurso':
                    $nome_minicurso = $this->input->get('nome_minicurso');
                    $nome_responsavel_minicurso = $this->input->get('nome_responsavel_minicurso');
                    $local_minicurso = $this->input->get('local_minicurso');
                    $certificado = $template->render(array('base_url'=>$base_url,'data_atividade'=>$data_atividade_extenso,'carga_horaria'=>$carga_horaria,'nome_aluno'=>$nome_aluno,'nome_minicurso'=>$nome_minicurso,'nome_responsavel_minicurso'=>$nome_responsavel_minicurso,'local_minicurso'=>$local_minicurso,'data_hoje'=>$data_hoje,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
                break;
                case 'ouvinte_workshop':
                    $workshop = $this->input->get('workshop');
                    $local_realizacao = $this->input->get('local_realizacao');
                    $certificado = $template->render(array('base_url'=>$base_url,'data_atividade'=>$data_atividade_extenso,'carga_horaria'=>$carga_horaria,'nome_aluno'=>$nome_aluno,'workshop'=>$workshop,'local_realizacao'=>$local_realizacao,'data_hoje'=>$data_hoje,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
                break;
                case 'palestra_aluno':
                    $nome_palestra_aluno = $this->input->get('nome_palestra_aluno');
                    $nome_responsavel_palestra_aluno = $this->input->get('nome_responsavel_palestra_aluno');
                    $local_palestra_aluno = $this->input->get('local_palestra_aluno');
                    $certificado = $template->render(array('base_url'=>$base_url,'data_atividade'=>$data_atividade_extenso,'nome_aluno'=>$nome_aluno,'nome_palestra_aluno'=>$nome_palestra_aluno,'nome_responsavel_palestra_aluno'=>$nome_responsavel_palestra_aluno,'local_palestra_aluno'=>$local_palestra_aluno,'carga_horaria'=>$carga_horaria,'data_hoje'=>$data_hoje,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
                break;
                case 'palestrante':
                    $nome_palestra_palestrante = $this->input->get('nome_palestra_palestrante');
                    $periodo_palestra_palestrante = $this->input->get('periodo_palestra_palestrante');
                    $local_palestra_palestrante = $this->input->get('local_palestra_palestrante');
                    $certificado = $template->render(array('base_url'=>$base_url,'data_atividade'=>$data_atividade_extenso,'carga_horaria'=>$carga_horaria,'nome_aluno'=>$nome_aluno,'nome_palestra_palestrante'=>$nome_palestra_palestrante,'periodo_palestra_palestrante'=>$periodo_palestra_palestrante,'local_palestra_palestrante'=>$local_palestra_palestrante,'data_hoje'=>$data_hoje,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
                break;
                case 'visita_tecnica':
                    $nome_empresa = $this->input->get('nome_empresa');
                    $municipio_empresa = $this->input->get('municipio_empresa');
                    $certificado = $template->render(array('base_url'=>$base_url,'nome_aluno'=>$nome_aluno,'nome_empresa'=>$nome_empresa,'municipio_empresa'=>$municipio_empresa,'carga_horaria'=>$carga_horaria,'data_hoje'=>$data_hoje,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
                break;
            }

            $options = new Options();
	    $options->set('isHtml5ParserEnabled', TRUE);
	    $options->set('isRemoteEnabled', TRUE);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($certificado);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            write_file('./assets/certificados/certificado.pdf',$dompdf->output(),'w+');
            $data['certificado'] = base_url().'assets/certificados/certificado.pdf';
            $data['sucesso'] = true;
        }
        echo json_encode($data);
    }
    
    public function gerar()
    {
        $data['sucesso'] = true;
        $id_atividade = $this->input->get('id_atividade');
        $base_url = base_url();
        
        $atividade = $this->mod_atividade->getByID($id_atividade);
        $data_atividade = $atividade->data_atividade;
        $data_atividade_extenso = utf8_encode(strftime('%d de %B de %Y',strtotime($atividade->data_atividade)));
        $data_hoje = utf8_encode(strftime('%d de %B de %Y', strtotime('today')));
        $carga_horaria = $atividade->carga_horaria;
        $ra_aluno = $atividade->ra_aluno;
        $nome_aluno = $this->mod_aluno->getNome($atividade->ra_aluno);
        $config = $this->mod_dashboard->getAll();
        $assinatura = $config->assinatura;
        $nome_diretor = $config->nome_diretor;
        
        $certificados = $this->mod_certificado->getByAtividade($id_atividade);
        $id_certificado = $certificados->id_certificado;

        
        $loader = new Twig_Loader_Filesystem('./assets/certificados/modelos');
        $twig = new Twig_Environment($loader);
        $template = $twig->load('tpl.'.$id_certificado.'.php');
        
        switch ($id_certificado) {
            case 'apoio':
                $evento = $certificados->evento;
                $periodo = $certificados->periodo;
                $certificado = $template->render(array('base_url' => $base_url, 'data_atividade' => $data_atividade_extenso, 'carga_horaria' => $carga_horaria, 'nome_aluno' => $nome_aluno, 'evento' => $evento, 'periodo' => $periodo, 'assinatura'=>$assinatura, 'nome_diretor'=>$nome_diretor));
            break;
            case 'apresentacao_de_trab':
                $nome_trabalho = $certificados->nome_trabalho;
                $local_apresentacao = $certificados->local_apresentacao;
                $certificado = $template->render(array('base_url'=>$base_url,'data_atividade'=>$data_atividade_extenso,'nome_aluno'=>$nome_aluno,'nome_trabalho'=>$nome_trabalho,'local_apresentacao'=>$local_apresentacao,'data_hoje'=>$data_hoje,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
            break; 
            case 'banca':
                $titulo_monografia = $certificados->titulo_monografia;
                $subtitulo_monografia = $certificados->subtitulo_monografia;
                $nome_completo_orientando = $certificados->nome_completo_orientando;
                $do_curso_superior_de = $certificados->do_curso_superior_de;
                $certificado = $template->render(array('base_url'=>$base_url,'data_atividade'=>$data_atividade_extenso,'nome_aluno'=>$nome_aluno,'titulo_monografia'=>$titulo_monografia,'subtitulo_monografia'=>$subtitulo_monografia,'nome_completo_orientando'=>$nome_completo_orientando,'do_curso_superior_de'=>$do_curso_superior_de,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
            break;
            case 'evento':
                $nome_evento = $certificados->nome_evento;
                $promovido_por = $certificados->promovido_por;
                $certificado = $template->render(array('base_url'=>$base_url,'data_atividade'=>$data_atividade_extenso,'nome_aluno'=>$nome_aluno,'nome_evento'=>$nome_evento,'promovido_por'=>$promovido_por,'data_hoje'=>$data_hoje,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
            break;
            case 'expositor':
                $nome_exposicao = $certificados->nome_exposicao;
                $periodo_exposicao = $certificados->periodo_exposicao;
                $certificado = $template->render(array('base_url'=>$base_url,'ra'=>$ra_aluno,'nome_aluno'=>$nome_aluno,'nome_exposicao'=>$nome_exposicao,'periodo_exposicao'=>$periodo_exposicao,'carga_horaria'=>$carga_horaria,'data_hoje'=>$data_hoje,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
            break;
            case 'minicurso':
                $nome_minicurso = $certificados->nome_minicurso;
                $nome_responsavel_minicurso = $certificados->nome_responsavel_minicurso;
                $local_minicurso = $certificados->local_minicurso;
                $certificado = $template->render(array('base_url'=>$base_url,'data_atividade'=>$data_atividade_extenso,'carga_horaria'=>$carga_horaria,'nome_aluno'=>$nome_aluno,'nome_minicurso'=>$nome_minicurso,'nome_responsavel_minicurso'=>$nome_responsavel_minicurso,'local_minicurso'=>$local_minicurso,'data_hoje'=>$data_hoje,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
            break;
            case 'ouvinte_workshop':
                $workshop = $certificados->workshop;
                $local_realizacao = $certificados->local_realizacao;
                $certificado = $template->render(array('base_url'=>$base_url,'data_atividade'=>$data_atividade_extenso,'carga_horaria'=>$carga_horaria,'nome_aluno'=>$nome_aluno,'workshop'=>$workshop,'local_realizacao'=>$local_realizacao,'data_hoje'=>$data_hoje,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
            break;
            case 'palestra_aluno':
                $nome_palestra_aluno = $certificados->nome_palestra_aluno;
                $nome_responsavel_palestra_aluno = $certificados->nome_responsavel_palestra_aluno;
                $local_palestra_aluno = $certificados->local_palestra_aluno;
                $certificado = $template->render(array('base_url'=>$base_url,'data_atividade'=>$data_atividade_extenso,'nome_aluno'=>$nome_aluno,'nome_palestra_aluno'=>$nome_palestra_aluno,'nome_responsavel_palestra_aluno'=>$nome_responsavel_palestra_aluno,'local_palestra_aluno'=>$local_palestra_aluno,'carga_horaria'=>$carga_horaria,'data_hoje'=>$data_hoje,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
            break;
            case 'palestrante':
                $nome_palestra_palestrante = $certificados->nome_palestra_palestrante;
                $periodo_palestra_palestrante = $certificados->periodo_palestra_palestrante;
                $local_palestra_palestrante = $certificados->local_palestra_palestrante;
                $certificado = $template->render(array('base_url'=>$base_url,'data_atividade'=>$data_atividade_extenso,'carga_horaria'=>$carga_horaria,'nome_aluno'=>$nome_aluno,'nome_palestra_palestrante'=>$nome_palestra_palestrante,'periodo_palestra_palestrante'=>$periodo_palestra_palestrante,'local_palestra_palestrante'=>$local_palestra_palestrante,'data_hoje'=>$data_hoje,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
            break;
            case 'visita_tecnica':
                $nome_empresa = $certificados->nome_empresa;
                $municipio_empresa = $certificados->municipio_empresa;
                $certificado = $template->render(array('base_url'=>$base_url,'nome_aluno'=>$nome_aluno,'nome_empresa'=>$nome_empresa,'municipio_empresa'=>$municipio_empresa,'carga_horaria'=>$carga_horaria,'data_hoje'=>$data_hoje,'assinatura'=>$assinatura,'nome_diretor'=>$nome_diretor));
            break;
        }

        $options = new Options();
	$options->set('isHtml5ParserEnabled', TRUE);
	$options->set('isRemoteEnabled', TRUE);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($certificado);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        write_file('./assets/certificados/certificado.pdf',$dompdf->output(),'w+');
        $data['certificado'] = base_url().'assets/certificados/certificado.pdf';
            
        echo json_encode($data);
    }
}
