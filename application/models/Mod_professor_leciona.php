<?php

class Mod_professor_leciona extends CI_Model {
    
    function getByID($id_professor){
        $sql = "SELECT * FROM professor_leciona WHERE id_professor = $id_professor";
        return $this->db->query($sql)->row();
    }

    function inserir($dados){
        $sql = "INSERT INTO professor_leciona (id_professor,id_curso) VALUES (?,?)";
        return $this->db->query($sql,$dados);
    }

    function delete($id_professor){
        $sql = "DELETE FROM professor_leciona WHERE id_professor = $id_professor";
        $this->db->query($sql);
    }

    function curso($id_professor,$id_curso){
        $sql = "SELECT * FROM professor_leciona WHERE id_professor=$id_professor and id_curso=$id_curso";
        return $this->db->query($sql)->row();
    }

   

}
