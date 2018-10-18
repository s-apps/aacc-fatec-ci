<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Atividade extends CI_Controller {
    
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
        $this->load->model('mod_aluno','mod_aluno');
        $this->load->model('mod_modalidade','mod_modalidade');
        $this->load->model('mod_certificado','mod_certificado');
        $this->load->model('mod_atividade','mod_atividade');
    }

    public function lista()
    {
        $busca = $this->input->get('busca');
        if(isset($busca)){
            $html = '';
            $lista = $this->mod_atividade->getAllByBusca($busca);
            foreach($lista as $atividade){
                $html .= '<tr>
                <td style="vertical-align : middle;">'.date('d/m/Y',strtotime($atividade->data_atividade)).'</td>
                <td style="vertical-align : middle;">'.$atividade->descricao_atividade.'</td>
                <!--<td style="vertical-align : middle;">nome_modalidade</td>-->
                <td style="vertical-align : middle;">'.$atividade->ra_aluno.'</td>
                <td style="vertical-align : middle;">'.$atividade->nome_aluno.'</td>
                <td style="width: 5%;text-align: center;vertical-align : middle;"><a href="'.base_url('admin/atividade/editar/'.$atividade->id_atividade).'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Editar</a></td>
                <td style="width: 5%;text-align: center;vertical-align : middle;"><button class="btn btn-warning btn-xs btnExcluir" data-id_atividade="'.$atividade->id_atividade.'"><i class="fa fa-trash-o"></i> Excluir</button></td>
        </tr>';
            }     
            $data['html'] = $html;
            echo json_encode($data);
        }else{
            $config['base_url'] = base_url() . 'admin/atividade/lista/';
            $config['total_rows'] = $this->mod_atividade->num_rows();
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
            $data['lista'] = $this->mod_atividade->getAll($config['per_page'],$config['per_page']*($page-1));
            $data['paginacao'] = $this->pagination->create_links();
        
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/atividade',$data);
            $this->load->view('tpl/footer');
            $data['newScript'] = '<script src="'. base_url('assets/js/aacc/atividade.js'). '"></script>'.PHP_EOL;
            $this->load->view('tpl/scripts',$data);
        }
    }

    public function adicionar()
    {
        $data['alunos'] = $this->mod_aluno->getAllSelect2();
        $data['modalidades'] = $this->mod_modalidade->getAllSelect2();
        $data['certificados'] = $this->mod_certificado->getAllSelect2();
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/add_atividade',$data);
        $this->load->view('tpl/footer');
        $data['newScript'] = '<script src="'. base_url('assets/js/bootstrap-timepicker.min.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/select2.min.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/i18n/pt-BR.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/jquery.inputmask.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/jquery.inputmask.date.extensions.js').'"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/jquery.inputmask.extensions.js').'"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/aacc/atividade.js'). '"></script>'.PHP_EOL;
        $this->load->view('tpl/scripts',$data);
    }

    public function carregaCamposCertificado()
    {
        $id_certificado = $this->input->get('id_certificado');
            switch ($id_certificado) {
                case 'apoio':
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="evento">Evento</label>
                        <input class="form-control" id="evento" name="evento" placeholder="Exemplo: XII Semana de Tecnologia" type="text" required="required" value="">
                    </div>
                    <div class="form-group">
                        <label for="periodo">Período</label>
                        <input class="form-control" id="periodo" name="periodo" placeholder="Exemplo: 24 a 27 de outubro de 2016" type="text" required="required">
                    </div>                
                    ';
                break;
                case 'apresentacao_de_trab':
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="nome_trabalho">Nome do Trabalho</label>
                        <input class="form-control" id="nome_trabalho" name="nome_trabalho" placeholder="Exemplo: A IMPORTÂNCIA DA VISÃO DE ORGANIZAÇÃO" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="local_apresentacao">Local da Apresentação</label>
                        <input class="form-control" id="local_apresentacao" name="local_apresentacao" placeholder="Exemplo: no I Workshop de Tecnologia e Informação" type="text" required="required">
                    </div>                
                    ';
                break;
                case 'banca':
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="titulo_monografia">Título da Monografia</label>
                        <input class="form-control" id="titulo_monografia" name="titulo_monografia" placeholder="Título Monografia" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="subtitulo_monografia">Subtítulo da Monografia</label>
                        <input class="form-control" id="subtitulo_monografia" name="subtitulo_monografia" placeholder="Subtítulo Monografia" type="text" required="required">
                    </div>                
                    <div class="form-group">
                        <label for="nome_completo_orientando">Nome completo do Orientando</label>
                        <input class="form-control" id="nome_completo_orientando" name="nome_completo_orientando" placeholder="Nome completo do Orientando" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="do_curso_superior_de">Do Curso Superior de</label>
                        <input class="form-control" id="do_curso_superior_de" name="do_curso_superior_de" placeholder="Exemplo: Tecnologia em Gestão Empresarial" type="text" required="required">
                    </div>                
                    ';
                break;
                case 'evento':
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="nome_evento">Nome do Evento</label>
                        <input class="form-control" id="nome_evento" name="nome_evento" placeholder="Exemplo: BootCamp 2017" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="promovido_por">Promovido por</label>
                        <input class="form-control" id="promovido_por" name="promovido_por" placeholder="Exemplo: Programa de Iniciação Científica" type="text" required="required">
                    </div>                
                    ';
                break;
                case 'expositor':
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="nome_exposicao">Nome da Exposição</label>
                        <input class="form-control" id="nome_exposicao" name="nome_exposicao" placeholder="Exemplo: I Feira de Empreendedorismo" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="periodo_exposicao">Período da Exposição</label>
                        <input class="form-control" id="periodo_exposicao" name="periodo_exposicao" placeholder="Exemplo: 24 a 27 de outubro de 2016" type="text" required="required">
                    </div>                
                    ';
                break;
                case 'minicurso':
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="nome_minicurso">Nome do Minicurso</label>
                        <input class="form-control" id="nome_minicurso" name="nome_minicurso" placeholder="Nome do Minicurso" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="nome_responsavel_minicurso">Nome do Responsável</label>
                        <input class="form-control" id="nome_responsavel_minicurso" name="nome_responsavel_minicurso" placeholder="Nome do Responsável" type="text" required="required">
                    </div>                
                    <div class="form-group">
                        <label for="local_minicurso">Local</label>
                        <input class="form-control" id="local_minicurso" name="local_minicurso" placeholder="Exemplo: nas dependências desta unidade" type="text" required="required">
                    </div>                
                    ';
                break;
                case 'ouvinte_workshop':
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="local_realizacao">Local da Realização</label>
                        <input class="form-control" id="local_realizacao" name="local_realizacao" placeholder="Exemplo: na XII Semana de Tecnologia" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="workshop">Workshop</label>
                        <input class="form-control" id="workshop" name="workshop" placeholder="Exemplo: do 6° Congresso de Pesquisa Científica" type="text" required="required">
                    </div>                
                    ';
                break;
                case 'palestra_aluno':
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="nome_palestra_aluno">Nome da Palestra</label>
                        <input class="form-control" id="nome_palestra_aluno" name="nome_palestra_aluno" placeholder="Nome da Palestra" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="nome_responsavel_palestra_aluno">Nome do Responsável</label>
                        <input class="form-control" id="nome_responsavel_palestra_aluno" name="nome_responsavel_palestra_aluno" placeholder="Nome do Responsável" type="text" required="required">
                    </div>                
                    <div class="form-group">
                        <label for="local_palestra_aluno">Local</label>
                        <input class="form-control" id="local_palestra_aluno" name="local_palestra_aluno" placeholder="Exemplo: nas dependências desta unidade" type="text" required="required">
                    </div>                
                    ';
                break;
                case 'palestrante':
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="nome_palestra_palestrante">Nome da Palestra</label>
                        <input class="form-control" id="nome_palestra_palestrante" name="nome_palestra_palestrante" placeholder="Nome da Palestra" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="periodo_palestra_palestrante">Período</label>
                        <select class="form-control" id="periodo_palestra_palestrante" name="periodo_palestra_palestrante" required="required">
                            <option value="matutino">Matutino</option>
                            <option value="vespertino">Vespertino</option>
                            <option value="noturno">Noturno</option>
                        </select>
                    </div>                
                    <div class="form-group">
                        <label for="local_palestra_palestrante">Local</label>
                        <input class="form-control" id="local_palestra_palestrante" name="local_palestra_palestrante" placeholder="Exemplo: nas dependências desta unidade" type="text" required="required">
                    </div>                
                    ';
                break;
                case 'visita_tecnica':
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="nome_empresa">Nome da Empresa</label>
                        <input class="form-control" id="nome_empresa" name="nome_empresa" placeholder="Exemplo: ICEMAX" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="municipio_empresa">Município</label>
                        <input class="form-control" id="municipio_empresa" name="municipio_empresa" placeholder="Exemplo: Garça/SP" type="text" required="required">
                    </div>                
                    ';
                break;
            }
           echo json_encode($data);
    }

    public function editaCamposCertificado()
    {
        $id_certificado = $this->input->get('id_certificado');
        $id_atividade = $this->input->get('id_atividade');
        $certificado = $this->mod_certificado->getCertificadoByAtividade($id_atividade,$id_certificado);
            switch ($id_certificado) {
                case 'apoio':
                    $evento = ($certificado!=null)?$certificado->evento:'';
                    $periodo = ($certificado!=null)?$certificado->periodo:'';
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="evento">Evento</label>
                        <input class="form-control" id="evento" name="evento" placeholder="Exemplo: XII Semana de Tecnologia" type="text" required="required" value="'.$evento.'">
                    </div>
                    <div class="form-group">
                        <label for="periodo">Período</label>
                        <input class="form-control" id="periodo" name="periodo" placeholder="Exemplo: 24 a 27 de outubro de 2016" type="text" required="required" value="'.$periodo.'">
                    </div>                
                    ';
                break;
                case 'apresentacao_de_trab':
                    $nome_trabalho = ($certificado!=null)?$certificado->nome_trabalho:'';
                    $local_apresentacao = ($certificado!=null)?$certificado->local_apresentacao:'';
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="nome_trabalho">Nome do Trabalho</label>
                        <input class="form-control" id="nome_trabalho" name="nome_trabalho" value="'.$nome_trabalho.'" placeholder="Exemplo: A IMPORTÂNCIA DA VISÃO DE ORGANIZAÇÃO" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="local_apresentacao">Local da Apresentação</label>
                        <input class="form-control" id="local_apresentacao" name="local_apresentacao" value="'.$local_apresentacao.'" placeholder="Exemplo: no I Workshop de Tecnologia e Informação" type="text" required="required">
                    </div>                
                    ';
                break;
                case 'banca':
                    $titulo_monografia = ($certificado!=null)?$certificado->titulo_monografia:'';
                    $subtitulo_monografia = ($certificado!=null)?$certificado->subtitulo_monografia:'';
                    $nome_completo_orientando = ($certificado!=null)?$certificado->nome_completo_orientando:'';
                    $do_curso_superior_de = ($certificado!=null)?$certificado->do_curso_superior_de:'';
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="titulo_monografia">Título da Monografia</label>
                        <input class="form-control" id="titulo_monografia" name="titulo_monografia" value="'.$titulo_monografia.'" placeholder="Título Monografia" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="subtitulo_monografia">Subtítulo da Monografia</label>
                        <input class="form-control" id="subtitulo_monografia" name="subtitulo_monografia" value="'.$subtitulo_monografia.'" placeholder="Subtítulo Monografia" type="text" required="required">
                    </div>                
                    <div class="form-group">
                        <label for="nome_completo_orientando">Nome completo do Orientando</label>
                        <input class="form-control" id="nome_completo_orientando" name="nome_completo_orientando" value="'.$nome_completo_orientando.'" placeholder="Nome completo do Orientando" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="do_curso_superior_de">Do Curso Superior de</label>
                        <input class="form-control" id="do_curso_superior_de" name="do_curso_superior_de" value="'.$do_curso_superior_de.'" placeholder="Exemplo: Tecnologia em Gestão Empresarial" type="text" required="required">
                    </div>                
                    ';
                break;
                case 'evento':
                    $nome_evento = ($certificado!=null)?$certificado->nome_evento:'';
                    $promovido_por =  ($certificado!=null)?$certificado->promovido_por:'';
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="nome_evento">Nome do Evento</label>
                        <input class="form-control" id="nome_evento" name="nome_evento" value="'.$nome_evento.'"placeholder="Exemplo: BootCamp 2017" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="promovido_por">Promovido por</label>
                        <input class="form-control" id="promovido_por" name="promovido_por" value="'.$promovido_por.'" placeholder="Exemplo: Programa de Iniciação Científica" type="text" required="required">
                    </div>                
                    ';
                break;
                case 'expositor':
                    $nome_exposicao = ($certificado!=null)?$certificado->nome_exposicao:'';
                    $periodo_exposicao = ($certificado!=null)?$certificado->periodo_exposicao:'';
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="nome_exposicao">Nome da Exposição</label>
                        <input class="form-control" id="nome_exposicao" name="nome_exposicao" placeholder="Exemplo: I Feira de Empreendedorismo" type="text" required="required" value="'.$nome_exposicao.'">
                    </div>
                    <div class="form-group">
                        <label for="periodo_exposicao">Período da Exposição</label>
                        <input class="form-control" id="periodo_exposicao" name="periodo_exposicao" placeholder="Exemplo: 24 a 27 de outubro de 2016" type="text" required="required" value="'.$periodo_exposicao.'">
                    </div>                
                    ';
                break;
                case 'minicurso':
                    $nome_minicurso = ($certificado!=null)?$certificado->nome_minicurso:'';
                    $nome_responsavel_minicurso = ($certificado!=null)?$certificado->nome_responsavel_minicurso:'';
                    $local_minicurso = ($certificado!=null)?$certificado->local_minicurso:'';
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="nome_minicurso">Nome do Minicurso</label>
                        <input class="form-control" id="nome_minicurso" name="nome_minicurso" value="'.$nome_minicurso.'" placeholder="Nome do Minicurso" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="nome_responsavel_minicurso">Nome do Responsável</label>
                        <input class="form-control" id="nome_responsavel_minicurso" name="nome_responsavel_minicurso" value="'.$nome_responsavel_minicurso.'" placeholder="Nome do Responsável" type="text" required="required">
                    </div>                
                    <div class="form-group">
                        <label for="local_minicurso">Local</label>
                        <input class="form-control" id="local_minicurso" name="local_minicurso" value="'.$local_minicurso.'" placeholder="Exemplo: nas dependências desta unidade" type="text" required="required">
                    </div>                
                    ';
                break;
                case 'ouvinte_workshop':
                    $local_realizacao = ($certificado!=null)?$certificado->local_realizacao:'';
                    $workshop = ($certificado!=null)?$certificado->workshop:'';
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="local_realizacao">Local da Realização</label>
                        <input class="form-control" id="local_realizacao" name="local_realizacao" value="'.$local_realizacao.'" placeholder="Exemplo: na XII Semana de Tecnologia" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="workshop">Workshop</label>
                        <input class="form-control" id="workshop" name="workshop" value="'.$workshop.'" placeholder="Exemplo: do 6° Congresso de Pesquisa Científica" type="text" required="required">
                    </div>                
                    ';
                break;
                case 'palestra_aluno':
                    $nome_palestra_aluno = ($certificado!=null)?$certificado->nome_palestra_aluno:'';
                    $nome_responsavel_palestra_aluno = ($certificado!=null)?$certificado->nome_responsavel_palestra_aluno:'';
                    $local_palestra_aluno = ($certificado!=null)?$certificado->local_palestra_aluno:'';
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="nome_palestra_aluno">Nome da Palestra</label>
                        <input class="form-control" id="nome_palestra_aluno" name="nome_palestra_aluno" value="'.$nome_palestra_aluno.'" placeholder="Nome da Palestra" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="nome_responsavel_palestra_aluno">Nome do Responsável</label>
                        <input class="form-control" id="nome_responsavel_palestra_aluno" name="nome_responsavel_palestra_aluno" value="'.$nome_responsavel_palestra_aluno.'" placeholder="Nome do Responsável" type="text" required="required">
                    </div>                
                    <div class="form-group">
                        <label for="local_palestra_aluno">Local</label>
                        <input class="form-control" id="local_palestra_aluno" name="local_palestra_aluno" value="'.$local_palestra_aluno.'" placeholder="Exemplo: nas dependências desta unidade" type="text" required="required">
                    </div>                
                    ';
                break;
                case 'palestrante':
                    $nome_palestra_palestrante = ($certificado!=null)?$certificado->nome_palestra_palestrante:'';
                    $periodo_palestra_palestrante = ($certificado!=null)?$certificado->periodo_palestra_palestrante:'';
                    $local_palestra_palestrante = ($certificado!=null)?$certificado->local_palestra_palestrante:'';
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="nome_palestra_palestrante">Nome da Palestra</label>
                        <input class="form-control" id="nome_palestra_palestrante" name="nome_palestra_palestrante" value="'.$nome_palestra_palestrante.'" placeholder="Nome da Palestra" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="periodo_palestra_palestrante">Período</label>
                        <select class="form-control" id="periodo_palestra_palestrante" name="periodo_palestra_palestrante" required="required">
                            <option value="matutino">Matutino</option>
                            <option value="vespertino">Vespertino</option>
                            <option value="noturno">Noturno</option>
                        </select>
                    </div>                
                    <div class="form-group">
                        <label for="local_palestra_palestrante">Local</label>
                        <input class="form-control" id="local_palestra_palestrante" name="local_palestra_palestrante" value="'.$local_palestra_palestrante.'" placeholder="Exemplo: nas dependências desta unidade" type="text" required="required">
                    </div>                
                    ';
                break;
                case 'visita_tecnica':
                    $nome_empresa = ($certificado!=null)?$certificado->nome_empresa:'';
                    $municipio_empresa = ($certificado!=null)?$certificado->municipio_empresa:'';
                    $data['campos_certificado'] = '
                    <div class="form-group">
                        <label for="nome_empresa">Nome da Empresa</label>
                        <input class="form-control" id="nome_empresa" name="nome_empresa" value="'.$nome_empresa.'" placeholder="Exemplo: ICEMAX" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="municipio_empresa">Município</label>
                        <input class="form-control" id="municipio_empresa" name="municipio_empresa" value="'.$municipio_empresa.'" placeholder="Exemplo: Garça/SP" type="text" required="required">
                    </div>                
                    ';
                break;
            }
           echo json_encode($data);
    }

    public function inserir()
    {
        $this->form_validation->set_rules('data_atividade', 'Data', 'required');
        $this->form_validation->set_rules('carga_horaria','Carga Horária','required');
        $this->form_validation->set_rules('descricao_atividade','Atividade','required');
        $this->form_validation->set_rules('ra_aluno','Aluno','required');
        $this->form_validation->set_rules('id_modalidade','Modalidade','callback_check_duracao['.$this->input->post('carga_horaria').']');
        $this->form_validation->set_rules('modeloCertificado','Certificado','required');
        $this->form_validation->set_error_delimiters('<p class="help-block" style="color:#ff0000;">', '</p>');
        if($this->form_validation->run() == FALSE){
            $data['alunos'] = $this->mod_aluno->getAllSelect2();
            $data['modalidades'] = $this->mod_modalidade->getAllSelect2();
            $data['certificados'] = $this->mod_certificado->getAllSelect2();
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/add_atividade',$data);
            $this->load->view('tpl/footer');
            $data['newScript'] = '<script src="'. base_url('assets/js/bootstrap-timepicker.min.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/select2.min.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/i18n/pt-BR.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/jquery.inputmask.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/jquery.inputmask.date.extensions.js').'"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/jquery.inputmask.extensions.js').'"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/aacc/atividade.js'). '"></script>'.PHP_EOL;
            $this->load->view('tpl/scripts',$data);
        }else{
            $data_atividade = $this->mod_atividade->converterData($this->input->post('data_atividade'));
            $dados = ['data_atividade'=>$data_atividade,'carga_horaria'=>$this->input->post('carga_horaria'),'descricao_atividade'=>$this->input->post('descricao_atividade'),'ra_aluno'=>$this->input->post('ra_aluno'),'id_modalidade'=>$this->input->post('id_modalidade'),'id_certificado'=>$this->input->post('modeloCertificado')];
            switch($this->input->post('modeloCertificado')){
                case 'apoio':
                    $dados['evento'] = $this->input->post('evento');
                    $dados['periodo'] = $this->input->post('periodo');
                break;
                case 'apresentacao_de_trab':
                    $dados['nome_trabalho'] = $this->input->post('nome_trabalho');
                    $dados['local_apresentacao'] = $this->input->post('local_apresentacao');
                break;
                case 'banca':
                    $dados['titulo_monografia'] = $this->input->post('titulo_monografia');
                    $dados['subtitulo_monografia'] = $this->input->post('subtitulo_monografia');
                    $dados['nome_completo_orientando'] = $this->input->post('nome_completo_orientando');
                    $dados['do_curso_superior_de'] = $this->input->post('do_curso_superior_de');
                break;
                case 'evento':
                    $dados['nome_evento'] = $this->input->post('nome_evento');
                    $dados['promovido_por'] = $this->input->post('promovido_por');
                break;
                case 'expositor':
                    $dados['nome_exposicao'] = $this->input->post('nome_exposicao');
                    $dados['periodo_exposicao'] = $this->input->post('periodo_exposicao');
                break;
                case 'minicurso':
                    $dados['nome_minicurso'] = $this->input->post('nome_minicurso');
                    $dados['nome_responsavel_minicurso'] = $this->input->post('nome_responsavel_minicurso');
                    $dados['local_minicurso'] = $this->input->post('local_minicurso');
                break;
                case 'ouvinte_workshop':
                    $dados['local_realizacao'] = $this->input->post('local_realizacao');
                    $dados['workshop'] = $this->input->post('workshop');
                break;
                case 'palestra_aluno':
                    $dados['nome_palestra_aluno'] = $this->input->post('nome_palestra_aluno');
                    $dados['nome_responsavel_palestra_aluno'] = $this->input->post('nome_responsavel_palestra_aluno');
                    $dados['local_palestra_aluno'] = $this->input->post('local_palestra_aluno');
                break;
                case 'palestrante':
                    $dados['nome_palestra_palestrante'] = $this->input->post('nome_palestra_palestrante');
                    $dados['periodo_palestra_palestrante'] = $this->input->post('periodo_palestra_palestrante');
                    $dados['local_palestra_palestrante'] = $this->input->post('local_palestra_palestrante');
                break;
                case 'visita_tecnica':
                    $dados['nome_empresa'] = $this->input->post('nome_empresa');
                    $dados['municipio_empresa'] = $this->input->post('municipio_empresa');
                break;
            }
            
            if($this->mod_atividade->inserir($dados)){
                redirect('admin/atividade/lista');
            }else{
                $data['erro'] = 'Ocorreu um erro inserindo na tabela atividade';
                $data['link'] = base_url('admin/atividade/adicionar');
                $this->load->view('tpl/header');
                $this->load->view('tpl/aside');
                $this->load->view('erro',$data);
                $this->load->view('tpl/footer');
                $this->load->view('tpl/scripts');
            }
        }
    }
    
    public function check_duracao($id_modalidade,$carga_horaria){
        //$duracao_modalidade = ($id_modalidade!=null)?$this->mod_modalidade->getDuracao($id_modalidade):'';
        if($id_modalidade==null){
            $this->form_validation->set_message('check_duracao', 'O campo <strong>Modalidade</strong> é requerido.');
            return FALSE;
        }
        $duracao_modalidade = $this->mod_modalidade->getDuracao($id_modalidade);
        if(date('H:i', strtotime($carga_horaria)) > date('H:i', strtotime($duracao_modalidade->duracao_modalidade))){
            $this->form_validation->set_message('check_duracao', 'A duração da <strong>Modalidade</strong> é de '.date('H:i',strtotime($duracao_modalidade->duracao_modalidade)).' horas <br/> Verifique a <strong>Carga Horária</strong> da Atividade');
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    public function editar($id_atividade)
    {
        $data['atividade'] = $this->mod_atividade->getByID($id_atividade);
        $data['alunos'] = $this->mod_aluno->getAllSelect2();
        $data['modalidades'] = $this->mod_modalidade->getAllSelect2();
        $data['certificados'] = $this->mod_certificado->getAllSelect2();

        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/edt_atividade',$data);
        $this->load->view('tpl/footer');
        $data['newScript'] = '<script src="'. base_url('assets/js/bootstrap-timepicker.min.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/select2.min.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/i18n/pt-BR.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/jquery.inputmask.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/jquery.inputmask.date.extensions.js').'"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/jquery.inputmask.extensions.js').'"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/aacc/atividade.js'). '"></script>'.PHP_EOL;
        $this->load->view('tpl/scripts',$data);

    }

    public function atualizar()
    {
        $this->form_validation->set_rules('data_atividade', 'Data', 'required');
        $this->form_validation->set_rules('carga_horaria','Carga Horária','required');
        $this->form_validation->set_rules('descricao_atividade','Atividade','required');
        $this->form_validation->set_rules('ra_aluno','Aluno','required');
        $this->form_validation->set_rules('id_modalidade','Modalidade','callback_check_duracao['.$this->input->post('carga_horaria').']');
        $this->form_validation->set_rules('modeloCertificado','Certificado','required');
        $this->form_validation->set_error_delimiters('<p class="help-block" style="color:#ff0000;">', '</p>');
        if($this->form_validation->run() == FALSE){
            $data['atividade'] = $this->mod_atividade->getByID($this->input->post('id_atividade'));
            $data['alunos'] = $this->mod_aluno->getAllSelect2();
            $data['modalidades'] = $this->mod_modalidade->getAllSelect2();
            $data['certificados'] = $this->mod_certificado->getAllSelect2();
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/edt_atividade',$data);
            $this->load->view('tpl/footer');
            $data['newScript'] = '<script src="'. base_url('assets/js/bootstrap-timepicker.min.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/select2.min.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/i18n/pt-BR.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/jquery.inputmask.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/jquery.inputmask.date.extensions.js').'"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/jquery.inputmask.extensions.js').'"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/aacc/atividade.js'). '"></script>'.PHP_EOL;
            $this->load->view('tpl/scripts',$data);
        }else{
            $data_atividade = $this->mod_atividade->converterData($this->input->post('data_atividade'));
            $dados = ['data_atividade'=>$data_atividade,'carga_horaria'=>$this->input->post('carga_horaria'),'descricao_atividade'=>$this->input->post('descricao_atividade'),'ra_aluno'=>$this->input->post('ra_aluno'),'id_modalidade'=>$this->input->post('id_modalidade'),'id_certificado'=>$this->input->post('modeloCertificado')];
            switch($this->input->post('modeloCertificado')){
                case 'apoio':
                    $dados['evento'] = $this->input->post('evento');
                    $dados['periodo'] = $this->input->post('periodo');
                break;
                case 'apresentacao_de_trab':
                    $dados['nome_trabalho'] = $this->input->post('nome_trabalho');
                    $dados['local_apresentacao'] = $this->input->post('local_apresentacao');
                break;
                case 'banca':
                    $dados['titulo_monografia'] = $this->input->post('titulo_monografia');
                    $dados['subtitulo_monografia'] = $this->input->post('subtitulo_monografia');
                    $dados['nome_completo_orientando'] = $this->input->post('nome_completo_orientando');
                    $dados['do_curso_superior_de'] = $this->input->post('do_curso_superior_de');
                break;
                case 'evento':
                    $dados['nome_evento'] = $this->input->post('nome_evento');
                    $dados['promovido_por'] = $this->input->post('promovido_por');
                break;
                case 'expositor':
                    $dados['nome_exposicao'] = $this->input->post('nome_exposicao');
                    $dados['periodo_exposicao'] = $this->input->post('periodo_exposicao');
                break;
                case 'minicurso':
                    $dados['nome_minicurso'] = $this->input->post('nome_minicurso');
                    $dados['nome_responsavel_minicurso'] = $this->input->post('nome_responsavel_minicurso');
                    $dados['local_minicurso'] = $this->input->post('local_minicurso');
                break;
                case 'ouvinte_workshop':
                    $dados['local_realizacao'] = $this->input->post('local_realizacao');
                    $dados['workshop'] = $this->input->post('workshop');
                break;
                case 'palestra_aluno':
                    $dados['nome_palestra_aluno'] = $this->input->post('nome_palestra_aluno');
                    $dados['nome_responsavel_palestra_aluno'] = $this->input->post('nome_responsavel_palestra_aluno');
                    $dados['local_palestra_aluno'] = $this->input->post('local_palestra_aluno');
                break;
                case 'palestrante':
                    $dados['nome_palestra_palestrante'] = $this->input->post('nome_palestra_palestrante');
                    $dados['periodo_palestra_palestrante'] = $this->input->post('periodo_palestra_palestrante');
                    $dados['local_palestra_palestrante'] = $this->input->post('local_palestra_palestrante');
                break;
                case 'visita_tecnica':
                    $dados['nome_empresa'] = $this->input->post('nome_empresa');
                    $dados['municipio_empresa'] = $this->input->post('municipio_empresa');
                break;
            }
            
            $dados['id_atividade'] = $this->input->post('id_atividade');

            if($this->mod_atividade->atualizar($dados)){
                redirect('admin/atividade/lista');
            }else{
                $data['erro'] = 'Ocorreu um erro atualizando na tabela atividade';
                $data['link'] = base_url('admin/atividade/editar/'.$this->input->post('id_atividade'));
                $this->load->view('tpl/header');
                $this->load->view('tpl/aside');
                $this->load->view('erro',$data);
                $this->load->view('tpl/footer');
                $this->load->view('tpl/scripts');
            }
        }
    }

    public function confirm_delete($id_atividade)
    {
        $dados = ['chave_primaria'=>$id_atividade,'from'=>'atividade','link'=>'admin/atividade/lista'];
        $data['dados'] = $dados;
        $atividade = $this->mod_atividade->getByID($id_atividade);
        $html = '<p>Data da Atividade: '.date('d/m/Y',strtotime($atividade->data_atividade)).'</p>';
        $html .= '<p>Atividade: '.$atividade->descricao_atividade.'</p>';
        $html .= '<p>RA: '.$atividade->ra_aluno.'</p>';
        $html .= '<p>Aluno: '.$this->mod_aluno->getNome($atividade->ra_aluno).'</p>';
        $data['html'] = $html;
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/confirm_delete',$data);
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }
    
    public function delete()
    {
        $this->mod_atividade->delete($this->input->post('chave_primaria'));
        $this->mod_atividade->delete_atividade_tem_certificado($this->input->post('chave_primaria'));
        redirect('admin/atividade/lista');
    }
    

}
