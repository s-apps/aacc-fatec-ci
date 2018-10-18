<?php

class Mod_atividade extends CI_Model {

    function converterData($data)
    {
    	$data_tmp = explode('/',$data);
    	$d_data = $data_tmp[0];
    	$m_data = $data_tmp[1];
    	$y_data = $data_tmp[2];
    	return $y_data.'-'.$m_data.'-'.$d_data;
    }    

    function inserir($dados){
        $resultado = false;
        $newDados = ['data_atividade'=>$dados['data_atividade'],'carga_horaria'=>$dados['carga_horaria'],'descricao_atividade'=>$dados['descricao_atividade'],'ra_aluno'=>$dados['ra_aluno'],'id_modalidade'=>$dados['id_modalidade'],'id_certificado'=>$dados['id_certificado']];
        $sql = "INSERT INTO atividade (data_atividade,carga_horaria,descricao_atividade,ra_aluno,id_modalidade,id_certificado) VALUES (?,?,?,?,?,?)";
        if($this->db->query($sql,$newDados)){
            $id_atividade = $this->db->insert_id();
            switch ($dados['id_certificado']) {
                case 'apoio':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'evento'=>$dados['evento'],'periodo'=>$dados['periodo']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,evento,periodo) VALUES (?,?,?,?,?)";
                break;
                case 'apresentacao_de_trab':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'nome_trabalho'=>$dados['nome_trabalho'],'local_apresentacao'=>$dados['local_apresentacao']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,nome_trabalho,local_apresentacao) VALUES (?,?,?,?,?)";
                break;
                case 'banca':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'titulo_monografia'=>$dados['titulo_monografia'],'subtitulo_monografia'=>$dados['subtitulo_monografia'],'nome_completo_orientando'=>$dados['nome_completo_orientando'],'do_curso_superior_de'=>$dados['do_curso_superior_de']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,titulo_monografia,subtitulo_monografia,nome_completo_orientando,do_curso_superior_de) VALUES (?,?,?,?,?,?,?)";
                break;
                case 'evento':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'nome_evento'=>$dados['nome_evento'],'promovido_por'=>$dados['promovido_por']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,nome_evento,promovido_por) VALUES (?,?,?,?,?)";
                break;
                case 'expositor':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'nome_exposicao'=>$dados['nome_exposicao'],'periodo_exposicao'=>$dados['periodo_exposicao']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,nome_exposicao,periodo_exposicao) VALUES (?,?,?,?,?)";
                break;  
                case 'minicurso':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'nome_minicurso'=>$dados['nome_minicurso'],'nome_responsavel_minicurso'=>$dados['nome_responsavel_minicurso'],'local_minicurso'=>$dados['local_minicurso']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,nome_minicurso,nome_responsavel_minicurso,local_minicurso) VALUES (?,?,?,?,?,?)";
                break;   
                case 'ouvinte_workshop':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'local_realizacao'=>$dados['local_realizacao'],'workshop'=>$dados['workshop']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,local_realizacao,workshop) VALUES (?,?,?,?,?)";
                break;  
                case 'palestra_aluno':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'nome_palestra_aluno'=>$dados['nome_palestra_aluno'],'nome_responsavel_palestra_aluno'=>$dados['nome_responsavel_palestra_aluno'],'local_palestra_aluno'=>$dados['local_palestra_aluno']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,nome_palestra_aluno,nome_responsavel_palestra_aluno,local_palestra_aluno) VALUES (?,?,?,?,?,?)";
                break; 
                case 'palestrante':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'nome_palestra_palestrante'=>$dados['nome_palestra_palestrante'],'periodo_palestra_palestrante'=>$dados['periodo_palestra_palestrante'],'local_palestra_palestrante'=>$dados['local_palestra_palestrante']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,nome_palestra_palestrante,periodo_palestra_palestrante,local_palestra_palestrante) VALUES (?,?,?,?,?,?)";
                break;
                case 'visita_tecnica':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'nome_empresa'=>$dados['nome_empresa'],'municipio_empresa'=>$dados['municipio_empresa']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,nome_empresa,municipio_empresa) VALUES (?,?,?,?,?)";
                break;
            }
            if($this->db->query($sql,$newDados)){
                $resultado = true;
            }
        }
        return $resultado;
    }

    function getAllByBusca($busca){
        $sql = "SELECT A.id_atividade,A.descricao_atividade,A.data_atividade,A.ra_aluno,M.nome_modalidade,AL.nome_aluno FROM atividade as A INNER JOIN modalidade as M ON A.id_modalidade = M.id_modalidade INNER JOIN aluno as AL ON A.ra_aluno = AL.ra WHERE A.descricao_atividade LIKE '%".$busca."%' OR A.ra_aluno LIKE '%".$busca."%' OR AL.nome_aluno LIKE '%".$busca."%' ORDER BY A.data_atividade DESC";
        return $this->db->query($sql)->result();
    }

    function num_rows(){
        $sql = "SELECT COUNT(id_atividade) as num_rows FROM atividade";
        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->num_rows;
    }

    function getAll($limit,$offset){
        $sql = "SELECT A.id_atividade,A.descricao_atividade,A.data_atividade,A.ra_aluno,M.nome_modalidade,AL.nome_aluno FROM atividade as A INNER JOIN modalidade as M ON A.id_modalidade = M.id_modalidade INNER JOIN aluno as AL ON A.ra_aluno = AL.ra ORDER BY A.data_atividade DESC LIMIT $limit OFFSET $offset";
        return $this->db->query($sql);
    }

    function getByID($id_atividade){
        $sql = "SELECT * FROM atividade WHERE id_atividade = $id_atividade";
        return $this->db->query($sql)->row();
    }

    function atualizar($dados){
        $resultado = false;

        $newDados = ['data_atividade'=>$dados['data_atividade'],'carga_horaria'=>$dados['carga_horaria'],'descricao_atividade'=>$dados['descricao_atividade'],'ra_aluno'=>$dados['ra_aluno'],'id_modalidade'=>$dados['id_modalidade'],'id_certificado'=>$dados['id_certificado'],'id_atividade'=>$dados['id_atividade']];
        $sql = "UPDATE atividade SET data_atividade=?,carga_horaria=?,descricao_atividade=?,ra_aluno=?,id_modalidade=?,id_certificado=? WHERE id_atividade = ?";
        if($this->db->query($sql,$newDados)){

            $id_atividade = $dados['id_atividade'];
            $id_certificado = $dados['id_certificado'];
    
            $sql = "DELETE FROM atividade_tem_certificado WHERE id_atividade = $id_atividade";
            $this->db->query($sql);

            switch ($dados['id_certificado']) {
                case 'apoio':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'evento'=>$dados['evento'],'periodo'=>$dados['periodo']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,evento,periodo) VALUES (?,?,?,?,?)";
                break;
                case 'apresentacao_de_trab':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'nome_trabalho'=>$dados['nome_trabalho'],'local_apresentacao'=>$dados['local_apresentacao']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,nome_trabalho,local_apresentacao) VALUES (?,?,?,?,?)";
                break;
                case 'banca':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'titulo_monografia'=>$dados['titulo_monografia'],'subtitulo_monografia'=>$dados['subtitulo_monografia'],'nome_completo_orientando'=>$dados['nome_completo_orientando'],'do_curso_superior_de'=>$dados['do_curso_superior_de']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,titulo_monografia,subtitulo_monografia,nome_completo_orientando,do_curso_superior_de) VALUES (?,?,?,?,?,?,?)";
                break;
                case 'evento':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'nome_evento'=>$dados['nome_evento'],'promovido_por'=>$dados['promovido_por']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,nome_evento,promovido_por) VALUES (?,?,?,?,?)";
                break;
                case 'expositor':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'nome_exposicao'=>$dados['nome_exposicao'],'periodo_exposicao'=>$dados['periodo_exposicao']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,nome_exposicao,periodo_exposicao) VALUES (?,?,?,?,?)";
                break;  
                case 'minicurso':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'nome_minicurso'=>$dados['nome_minicurso'],'nome_responsavel_minicurso'=>$dados['nome_responsavel_minicurso'],'local_minicurso'=>$dados['local_minicurso']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,nome_minicurso,nome_responsavel_minicurso,local_minicurso) VALUES (?,?,?,?,?,?)";
                break;   
                case 'ouvinte_workshop':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'local_realizacao'=>$dados['local_realizacao'],'workshop'=>$dados['workshop']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,local_realizacao,workshop) VALUES (?,?,?,?,?)";
                break;  
                case 'palestra_aluno':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'nome_palestra_aluno'=>$dados['nome_palestra_aluno'],'nome_responsavel_palestra_aluno'=>$dados['nome_responsavel_palestra_aluno'],'local_palestra_aluno'=>$dados['local_palestra_aluno']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,nome_palestra_aluno,nome_responsavel_palestra_aluno,local_palestra_aluno) VALUES (?,?,?,?,?,?)";
                break; 
                case 'palestrante':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'nome_palestra_palestrante'=>$dados['nome_palestra_palestrante'],'periodo_palestra_palestrante'=>$dados['periodo_palestra_palestrante'],'local_palestra_palestrante'=>$dados['local_palestra_palestrante']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,nome_palestra_palestrante,periodo_palestra_palestrante,local_palestra_palestrante) VALUES (?,?,?,?,?,?)";
                break;
                case 'visita_tecnica':
                    $newDados = ['id_atividade'=>$id_atividade,'id_certificado'=>$dados['id_certificado'],'ra_aluno'=>$dados['ra_aluno'],'nome_empresa'=>$dados['nome_empresa'],'municipio_empresa'=>$dados['municipio_empresa']];
                    $sql = "INSERT INTO atividade_tem_certificado (id_atividade,id_certificado,ra_aluno,nome_empresa,municipio_empresa) VALUES (?,?,?,?,?)";
                break;
            }
            if($this->db->query($sql,$newDados)){
                $resultado = true;
            }
        }
        return $resultado;
    }

    function getAllByRA($ra_aluno){
        $sql = "SELECT id_atividade,data_atividade,descricao_atividade,carga_horaria FROM atividade WHERE ra_aluno = $ra_aluno";
        return $this->db->query($sql)->result();
    }

    function getAllByModalidadeRA($id_modalidade,$ra_aluno){
        $sql = "SELECT id_atividade,data_atividade,descricao_atividade,carga_horaria FROM atividade WHERE ra_aluno = $ra_aluno AND id_modalidade = $id_modalidade";
        return $this->db->query($sql)->result();
    }
    
    function delete($id_atividade){
        $sql = "DELETE FROM atividade WHERE id_atividade = $id_atividade";
        return $this->db->query($sql);
    }
    
    function delete_atividade_tem_certificado($id_atividade){
        $sql = "DELETE FROM atividade_tem_certificado WHERE id_atividade = $id_atividade";
        return $this->db->query($sql);
    }
    
}
