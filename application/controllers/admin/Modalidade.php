<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Modalidade extends CI_Controller {
    
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
        $this->load->model('mod_comprovante','mod_comprovante');
        $this->load->model('mod_modalidade','mod_modalidade');
    }

    public function lista()
    {
        $busca = $this->input->get('busca');
        if(isset($busca)){
            $html = '';
            $lista = $this->mod_modalidade->getAllByBusca($busca);
            foreach($lista as $modalidade){
                $html .= '<tr>
                <td>'.$modalidade->nome_modalidade.'</td>
                <td style="width: 5%;text-align: center;"><a href="'.base_url('admin/modalidade/editar/'.$modalidade->id_modalidade).'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Editar</a></td>
                <td style="width: 5%;text-align: center;"><a href="'.base_url('admin/modalidade/confirm-delete/'.$modalidade->id_modalidade).'" class="btn btn-warning btn-xs"><i class="fa fa-trash-o"></i> Excluir</a></td>
            </tr>';
            }     
            $data['html'] = $html;
            echo json_encode($data);
        }else{
            $config['base_url'] = base_url() . 'admin/modalidade/lista/';
            $config['total_rows'] = $this->mod_modalidade->num_rows();
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
            $data['lista'] = $this->mod_modalidade->getAll($config['per_page'],$config['per_page']*($page-1));
            $data['paginacao'] = $this->pagination->create_links();
        
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/modalidade',$data);
            $this->load->view('tpl/footer');
            $data['newScript'] = '<script src="'. base_url('assets/js/aacc/modalidade.js'). '"></script>'.PHP_EOL;
            $this->load->view('tpl/scripts',$data);
        }
    }
    
    public function adicionar()
    {
        $data['categorias'] = $this->mod_categoria->getAllSelect2();
        $data['comprovantes'] = $this->mod_comprovante->getAllSelect2();
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/add_modalidade',$data);
        $this->load->view('tpl/footer');
        $data['newScript'] = '<script src="'. base_url('assets/js/bootstrap-timepicker.min.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/select2.min.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/i18n/pt-BR.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/aacc/modalidade.js'). '"></script>'.PHP_EOL;
        $this->load->view('tpl/scripts',$data);
    }
    
    public function inserir()
    {
        $this->form_validation->set_rules('id_categoria','Categoria','required');
        $this->form_validation->set_rules('id_comprovante','Comprovante','required');
        $this->form_validation->set_rules('nome_modalidade', 'Modalidade', 'required');
        $this->form_validation->set_rules('duracao_modalidade', 'Duração', 'required');
        $this->form_validation->set_rules('limite_modalidade', 'Limite', 'required');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/add_modalidade');
            $this->load->view('tpl/footer');
            $data['newScript'] = '<script src="'. base_url('assets/js/bootstrap-timepicker.min.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/select2.min.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/i18n/pt-BR.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/aacc/modalidade.js'). '"></script>'.PHP_EOL;
            $this->load->view('tpl/scripts',$data);
        }else{
            $dados = [
                'id_categoria'=>$this->input->post('id_categoria'),
                'id_comprovante'=>$this->input->post('id_comprovante'),
                'nome_modalidade'=>$this->input->post('nome_modalidade'),
                'duracao_modalidade'=>$this->input->post('duracao_modalidade'),                
                'limite_modalidade'=>$this->input->post('limite_modalidade')
            ];
            if($this->mod_modalidade->inserir($dados)){
                redirect('admin/modalidade/lista');
            }else{
                $data['erro'] = 'Ocorreu um erro inserindo na tabela modalidade';
                $data['link'] = base_url('admin/modalidade/adicionar');
                $this->load->view('tpl/header');
                $this->load->view('tpl/aside');
                $this->load->view('erro',$data);
                $this->load->view('tpl/footer');
                $this->load->view('tpl/scripts');
            }
        }
    }
    
    public function editar($id_modalidade)
    {
        $data['categorias'] = $this->mod_categoria->getAllSelect2();
        $data['comprovantes'] = $this->mod_comprovante->getAllSelect2();
        $data['modalidade'] = $this->mod_modalidade->getByID($id_modalidade);
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/edt_modalidade',$data);
        $this->load->view('tpl/footer');
        $data['newScript'] = '<script src="'. base_url('assets/js/bootstrap-timepicker.min.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/select2.min.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/i18n/pt-BR.js'). '"></script>'.PHP_EOL;
        $data['newScript'] .= '<script src="'. base_url('assets/js/aacc/modalidade.js'). '"></script>'.PHP_EOL;
        $this->load->view('tpl/scripts',$data);
    }
    
    public function atualizar()
    {
        $this->form_validation->set_rules('id_categoria','Categoria','required');
        $this->form_validation->set_rules('id_comprovante','Comprovante','required');
        $this->form_validation->set_rules('nome_modalidade', 'Modalidade', 'required');
        $this->form_validation->set_rules('duracao_modalidade', 'Duração', 'required');
        $this->form_validation->set_rules('limite_modalidade', 'Limite', 'required');
        $this->form_validation->set_error_delimiters('<div style="color:#ff0000;">', '</div>');
        if($this->form_validation->run() == FALSE){
            $this->load->view('tpl/header');
            $this->load->view('tpl/aside');
            $this->load->view('admin/edt_modalidade');
            $this->load->view('tpl/footer');
            $data['newScript'] = '<script src="'. base_url('assets/js/bootstrap-timepicker.min.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/select2.min.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/select2/js/i18n/pt-BR.js'). '"></script>'.PHP_EOL;
            $data['newScript'] .= '<script src="'. base_url('assets/js/aacc/modalidade.js'). '"></script>'.PHP_EOL;
            $this->load->view('tpl/scripts',$data);
        }else{
            $dados = [
                'id_categoria'=>$this->input->post('id_categoria'),
                'id_comprovante'=>$this->input->post('id_comprovante'),
                'nome_modalidade'=>$this->input->post('nome_modalidade'),
                'duracao_modalidade'=>$this->input->post('duracao_modalidade'),                
                'limite_modalidade'=>$this->input->post('limite_modalidade'),
                'id_modalidade'=>$this->input->post('id_modalidade')
            ];
            if($this->mod_modalidade->atualizar($dados)){
                redirect('admin/modalidade/lista');
            }else{
                $data['erro'] = 'Ocorreu um erro atualizando na tabela modalidade';
                $data['link'] = base_url('admin/modalidade/editar/'.$this->input->post('id_modalidade'));
                $this->load->view('tpl/header');
                $this->load->view('tpl/aside');
                $this->load->view('erro',$data);
                $this->load->view('tpl/footer');
                $this->load->view('tpl/scripts');
            }
        }
    }

    public function addCategoria()
    {
        $html = '<form id="frmAddCategoriaExtra" name="frmAddCategoriaExtra" method="POST" action="'.base_url('admin/categoria/addCategoriaExtra').'">';
        $html .= '<div class="modal-header">';
        $html .= '<h4 class="modal-title"><i class="fa fa-plus"></i> Categoria</h4>';
        $html .= '</div><!--modal-header-->';
        $html .= '<div class="modal-body">';
        $html .= '<div class="form-group">
                    <label for="categoriaExtra">Categoria</label>
                    <input type="text" class="form-control" id="categoriaExtra" placeholder="Informe a Categoria">
                    <p class="help-block" style="color:#ff0000;" id="erroExtra"></p>
                  </div>';
        $html .= '</div><!--modal-body-->';
        $html .= '<div class="modal-footer">';
        $html .= '<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Salvar</button>';
        $html .= '<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-undo"></i> Cancelar</button>';
        $html .= '</div><!--modal-footer-->';
        $html .= '</form>';
        $data['html'] = $html;
        echo json_encode($data);
    }

    public function addComprovante()
    {
        $html = '<form id="frmAddComprovanteExtra" name="frmAddComprovanteExtra" method="POST" action="'.base_url('admin/comprovante/addComprovanteExtra').'">';
        $html .= '<div class="modal-header">';
        $html .= '<h4 class="modal-title"><i class="fa fa-plus"></i> Comprovante</h4>';
        $html .= '</div><!--modal-header-->';
        $html .= '<div class="modal-body">';
        $html .= '<div class="form-group">
                    <label for="comprovanteExtra">Comprovante</label>
                    <input type="text" class="form-control" id="comprovanteExtra" placeholder="Informe o Comprovante">
                    <p class="help-block" style="color:#ff0000;" id="erroExtra"></p>
                  </div>';
        $html .= '</div><!--modal-body-->';
        $html .= '<div class="modal-footer">';
        $html .= '<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Salvar</button>';
        $html .= '<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-undo"></i> Cancelar</button>';
        $html .= '</div><!--modal-footer-->';
        $html .= '</form>';
        $data['html'] = $html;
        echo json_encode($data);
    }

    public function confirm_delete($id_modalidade)
    {
        $dados = ['chave_primaria'=>$id_modalidade,'from'=>'modalidade','link'=>'admin/modalidade/lista'];
        $data['dados'] = $dados;
        $modalidade = $this->mod_modalidade->getByID($id_modalidade);
        $html = '<p>Modalidade: '.$modalidade->nome_modalidade.'</p>';
        $html .= '<p>Duração: '.date('H:i',strtotime($modalidade->duracao_modalidade)).'</p>';
        $html .= '<p>Limite em Horas: '.date('H:i',strtotime($modalidade->limite_modalidade)).'</p>';
        $html .= '<p>Atividades Relacionadas: (<strong>'.$this->mod_modalidade->countAtividades($id_modalidade).'</strong>) Atividades Relacionadas também serão excluídas.</p>';
        $data['html'] = $html;
        $this->load->view('tpl/header');
        $this->load->view('tpl/aside');
        $this->load->view('admin/confirm_delete',$data);
        $this->load->view('tpl/footer');
        $this->load->view('tpl/scripts');
    }
    
    public function delete()
    {
        $id_atividades = $this->mod_modalidade->getAtividadesByModalidade($this->input->post('chave_primaria'));
        foreach ($id_atividades as $atividade){
            $this->mod_modalidade->delete_atividade($this->input->post('chave_primaria'));
            $this->mod_modalidade->delete_atividade_tem_certificado($atividade->id_atividade);
        }
        $this->mod_modalidade->delete($this->input->post('chave_primaria'));
        redirect('admin/modalidade/lista');
    }
    
    
}
