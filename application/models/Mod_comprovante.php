<?php

class Mod_comprovante extends CI_Model {
    
    function inserir($nome_comprovante){
        $sql = "INSERT INTO comprovante (nome_comprovante) VALUES ('$nome_comprovante') 
                ON DUPLICATE KEY UPDATE nome_comprovante = '$nome_comprovante'";
        return $this->db->query($sql);
    }
    
    function getAll($limit,$offset){
        $sql = "SELECT id_comprovante, nome_comprovante FROM comprovante ORDER BY nome_comprovante ASC LIMIT $limit OFFSET $offset";
        return $this->db->query($sql);
    }

    function getAllSelect2(){
        $sql = "SELECT id_comprovante, nome_comprovante FROM comprovante ORDER BY nome_comprovante ASC";
        return $this->db->query($sql)->result();
    }
    
    function num_rows(){
        $sql = "SELECT COUNT(id_comprovante) as num_rows FROM comprovante";
        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->num_rows;
    }
    
    function getByID($id_comprovante){
        $sql = "SELECT * FROM comprovante WHERE id_comprovante = $id_comprovante";
        $query = $this->db->query($sql);
        return $row = $query->row();
    }
    
    function atualizar($dados){
        $sql = "UPDATE IGNORE comprovante SET nome_comprovante = ?
                WHERE id_comprovante = ?";
        return $this->db->query($sql,$dados);
    }

    function getByNomeComprovante($nomeComprovante){
        $sql = "SELECT * FROM comprovante WHERE nome_comprovante = '$nomeComprovante'";
        return $this->db->query($sql)->row();
    }

    
}
