<?php

class Mod_professor extends CI_Model {
    
    function inserir($dados){
        $sql = "INSERT INTO professor (nome_professor,email,senha) VALUES (?,?,?)";
        return $this->db->query($sql,$dados);
    }

    function getAll($limit,$offset){
        $sql = "SELECT id_professor, nome_professor, email FROM professor ORDER BY nome_professor ASC LIMIT $limit OFFSET $offset";
        return $this->db->query($sql);
    }

    function getAllByBusca($busca){
        $sql = "SELECT id_professor, nome_professor, email FROM professor WHERE nome_professor LIKE '%".$busca."%' ORDER BY nome_professor";
        return $this->db->query($sql)->result();
    }

    function num_rows(){
        $sql = "SELECT COUNT(id_professor) as num_rows FROM professor";
        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->num_rows;
    }
    
    function getByID($id_professor){
        $sql = "SELECT * FROM professor WHERE id_professor = $id_professor";
        return $this->db->query($sql)->row();
    }
    
    function atualizar($dados){
        if(!is_null($dados['senha'])){
            $sql = "UPDATE IGNORE professor SET nome_professor=?,email=?,senha=? WHERE id_professor = ?";
        }else{
            unset($dados['senha']);
            $sql = "UPDATE IGNORE professor SET nome_professor=?,email=? WHERE id_professor = ?";
        }
        return $this->db->query($sql,$dados);
    }
    
    function emailExiste($email){
        $sql = "SELECT COUNT(id_professor) as num_rows FROM professor WHERE email = '$email'";
        $query = $this->db->query($sql);
        $row = $query->row();      
        if($row->num_rows==0){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    function delete($id_professor){
        $sql = "DELETE FROM professor WHERE id_professor = $id_professor";
        return $this->db->query($sql);
    }
    
    function delete_professor_leciona($id_professor){
        $sql = "DELETE FROM professor_leciona WHERE id_professor = $id_professor";
        return $this->db->query($sql);
    }
    
}
