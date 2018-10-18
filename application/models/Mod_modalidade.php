<?php

class Mod_modalidade extends CI_Model {
    
    function inserir($dados){
        $nome_modalidade = $dados['nome_modalidade'];
        $sql = "INSERT INTO modalidade (id_categoria,id_comprovante,nome_modalidade,duracao_modalidade,limite_modalidade) VALUES (?,?,?,?,?) 
                ON DUPLICATE KEY UPDATE nome_modalidade = '$nome_modalidade'";
        return $this->db->query($sql,$dados);
    }
    
    function getAll($limit,$offset){
        $sql = "SELECT id_modalidade, nome_modalidade FROM modalidade ORDER BY nome_modalidade ASC LIMIT $limit OFFSET $offset";
        return $this->db->query($sql);
    }

    function getAllSelect2(){
        $sql = "SELECT id_modalidade, nome_modalidade, duracao_modalidade FROM modalidade ORDER BY nome_modalidade ASC";
        return $this->db->query($sql)->result();
    }

    function num_rows(){
        $sql = "SELECT COUNT(id_modalidade) as num_rows FROM modalidade";
        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->num_rows;
    }
    
    function getByID($id_modalidade){
        $sql = "SELECT * FROM modalidade WHERE id_modalidade = $id_modalidade";
        return $this->db->query($sql)->row();
    }
    
    function atualizar($dados){
        $sql = "UPDATE IGNORE modalidade SET id_categoria=?,id_comprovante=?,nome_modalidade=?,duracao_modalidade=?,limite_modalidade=? WHERE id_modalidade = ?";
        return $this->db->query($sql,$dados);
    }

    function getAllByBusca($busca){
        $sql = "SELECT id_modalidade, nome_modalidade FROM modalidade WHERE nome_modalidade LIKE '%".$busca."%' ORDER BY nome_modalidade";
        return $this->db->query($sql)->result();
    }
    
    function countAtividades($id_modalidade){
        $sql = "SELECT count(id_modalidade) as total_atividades FROM atividade WHERE id_modalidade = $id_modalidade";
        $row = $this->db->query($sql)->row();
        return $row->total_atividades;
    }

    function delete($id_modalidade){
        $sql = "DELETE FROM modalidade WHERE id_modalidade = $id_modalidade";
        return $this->db->query($sql);
    }
    
    function getAtividadesByModalidade($id_modalidade){
        $sql = "SELECT id_atividade FROM atividade WHERE id_modalidade = $id_modalidade";
        return $this->db->query($sql)->result();
    }
    
    function delete_atividade($id_modalidade){
        $sql = "DELETE FROM atividade WHERE id_modalidade = $id_modalidade";
        return $this->db->query($sql);
    }
    
    function delete_atividade_tem_certificado($id_atividade){
        $sql = "DELETE FROM atividade_tem_certificado WHERE id_atividade = $id_atividade";
        return $this->db->query($sql);
    }
    
    function getAllLista(){
        $sql = "SELECT * FROM modalidade ORDER BY nome_modalidade ASC";
        return $this->db->query($sql)->result();
    }
    
    function getDuracao($id_modalidade){
        $sql = "SELECT duracao_modalidade FROM modalidade WHERE id_modalidade = $id_modalidade";
        return $this->db->query($sql)->row();
    }
    
}
