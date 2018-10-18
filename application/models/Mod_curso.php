<?php

class Mod_curso extends CI_Model {
    
    function inserir($nome_curso){
        $sql = "INSERT INTO curso (nome_curso) VALUES ('$nome_curso') 
                ON DUPLICATE KEY UPDATE nome_curso = '$nome_curso'";
        return $this->db->query($sql);
    }
    
    function getAll($limit,$offset){
        $sql = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC LIMIT $limit OFFSET $offset";
        return $this->db->query($sql);
    }

    function getAllSelect2(){
        $sql = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";
        return $this->db->query($sql)->result();
    }
    
    function num_rows(){
        $sql = "SELECT COUNT(id_curso) as num_rows FROM curso";
        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->num_rows;
    }
    
    function getByID($id_curso){
        $sql = "SELECT * FROM curso WHERE id_curso = $id_curso";
        return $this->db->query($sql)->row();
    }
    
    function atualizar($dados){
        $sql = "UPDATE IGNORE curso SET nome_curso = ?
                WHERE id_curso = ?";
        return $this->db->query($sql,$dados);
    }
    
}
