<?php

class Mod_administrador extends CI_Model {
    
    function inserir($dados){
        $email = $dados['email'];
        $sql = "INSERT INTO administrador (nome_administrador,email,senha) VALUES (?,?,?) 
                ON DUPLICATE KEY UPDATE email = '$email'";
        return $this->db->query($sql,$dados);
    }
    
    function getAll($limit,$offset){
        $sql = "SELECT * FROM administrador ORDER BY nome_administrador ASC LIMIT $limit OFFSET $offset";
        return $this->db->query($sql);
    }

    function num_rows(){
        $sql = "SELECT COUNT(id_administrador) as num_rows FROM administrador";
        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->num_rows;
    }
    
    function getByID($id_administrador){
        $sql = "SELECT * FROM administrador WHERE id_administrador = $id_administrador";
        return $this->db->query($sql)->row();
    }
    
    function atualizar($dados){
        if(!is_null($dados['senha'])){
            $sql = "UPDATE IGNORE administrador SET nome_administrador=?,email=?,senha=? WHERE id_administrador = ?";
        }else{
            unset($dados['senha']);
            $sql = "UPDATE IGNORE administrador SET nome_administrador=?,email=? WHERE id_administrador = ?";
        }
        return $this->db->query($sql,$dados);
    }
    
    function existe($email,$senha){
        $sql = "SELECT id_administrador,nome_administrador FROM administrador WHERE email='$email' AND senha='$senha'";
        return $this->db->query($sql)->row();
    }
    
    function delete($id_administrador){
        $sql = "DELETE FROM administrador WHERE id_administrador= $id_administrador";
        return $this->db->query($sql);
    }
    
    function emailExiste($email){
        $sql = "SELECT email FROM administrador WHERE email = '$email'";
        return $this->db->query($sql)->row();
    }
    
    function senhaTempExiste($email,$senha){
        $sql = "SELECT senha_temporaria FROM administrador WHERE email='$email' AND senha_temporaria = '$senha'";
        return $this->db->query($sql)->row();
    }
    
    function updateSenhaTemporaria($email,$senha_temporaria){
        $sql = "UPDATE administrador SET senha_temporaria='$senha_temporaria' WHERE email='$email'";
        return $this->db->query($sql);
    }
    
    function updateSenha($email,$senha){
        $sql = "UPDATE administrador SET senha = '$senha', senha_temporaria = null WHERE email = '$email'";
        return $this->db->query($sql);
    }
    
}
