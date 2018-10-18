<?php

class Mod_categoria extends CI_Model {
    
    function inserir($nome_categoria){
        $sql = "INSERT INTO categoria(nome_categoria) VALUES ('$nome_categoria') 
                ON DUPLICATE KEY UPDATE nome_categoria = '$nome_categoria'";
        return $this->db->query($sql);
    }
    
    function getAll($limit,$offset){
        $sql = "SELECT id_categoria, nome_categoria FROM categoria ORDER BY nome_categoria ASC LIMIT $limit OFFSET $offset";
        return $this->db->query($sql);
    }

    function getAllSelect2(){
        $sql = "SELECT id_categoria, nome_categoria FROM categoria ORDER BY nome_categoria ASC";
        return $this->db->query($sql)->result();
    }
    
    function num_rows(){
        $sql = "SELECT COUNT(id_categoria) as num_rows FROM categoria";
        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->num_rows;
    }
    
    function getByID($id_categoria){
        $sql = "SELECT * FROM categoria WHERE id_categoria = $id_categoria";
        return $this->db->query($sql)->row();
    }

    function getByNomeCategoria($nomeCategoria){
        $sql = "SELECT * FROM categoria WHERE nome_categoria = '$nomeCategoria'";
        return $this->db->query($sql)->row();
    }
    
    function atualizar($dados){
        $sql = "UPDATE IGNORE categoria SET nome_categoria = ?
                WHERE id_categoria = ?";
        return $this->db->query($sql,$dados);
    }
    
}
