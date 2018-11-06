<?php

class Mod_aluno extends CI_Model {
    
    function inserir($dados){
        $sql = "INSERT INTO aluno (ra,nome_aluno,email,senha,id_curso) VALUES (?,?,?,?,?)";
        return $this->db->query($sql,$dados);
    }
    
    function getAll($limit,$offset){
        $sql = "SELECT ra, nome_aluno, email FROM aluno ORDER BY nome_aluno ASC LIMIT $limit OFFSET $offset";
        return $this->db->query($sql);
    }

    function getAllByBusca($busca){
        $sql = "SELECT ra, nome_aluno, email FROM aluno WHERE ra LIKE '%".$busca."%' OR nome_aluno LIKE '%".$busca."%' ORDER BY nome_aluno";
        return $this->db->query($sql)->result();
    }

    function getAllSelect2(){
        $sql = "SELECT ra, nome_aluno FROM aluno ORDER BY nome_aluno ASC";
        return $this->db->query($sql)->result();
    }
    
    function num_rows(){
        $sql = "SELECT COUNT(ra) as num_rows FROM aluno";
        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->num_rows;
    }
    
    function getByRA($ra){
        $sql = "SELECT A.ra,A.nome_aluno,A.email,A.id_curso,C.nome_curso FROM aluno as A INNER JOIN curso as C ON A.id_curso = C.id_curso WHERE ra = '$ra'";
        return $this->db->query($sql)->row();
    }

    function getNome($ra){
        $sql = "SELECT nome_aluno FROM aluno WHERE ra = '$ra'";
        $row = $this->db->query($sql)->row();
        return $row->nome_aluno;
    }
    
    function atualizar($dados){
        if(!is_null($dados['senha'])){
            $sql = "UPDATE IGNORE aluno SET nome_aluno=?,email=?,senha=?,id_curso=? WHERE ra = ?";
        }else{
            unset($dados['senha']);
            $sql = "UPDATE IGNORE aluno SET nome_aluno=?,email=?,id_curso=? WHERE ra = ?";
        }
        return $this->db->query($sql,$dados);
    }
    
    function raExiste($ra){
        $sql = "SELECT COUNT(ra) as num_rows FROM aluno WHERE ra = '$ra'";
        $query = $this->db->query($sql);
        $row = $query->row();      
        if($row->num_rows==0){
            return FALSE;
        }else{
            return TRUE;
        }
    }

    function emailExiste($email){
        $sql = "SELECT COUNT(ra) as num_rows FROM aluno WHERE email = '$email'";
        $query = $this->db->query($sql);
        $row = $query->row();      
        if($row->num_rows==0){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    function existe($email,$senha){
        $sql = "SELECT ra,nome_aluno FROM aluno WHERE email='$email' AND senha='$senha'";
        return $this->db->query($sql)->row();
    }
    
    function countAtividades($ra_aluno){
        $sql = "SELECT count(ra_aluno) as total_atividades FROM atividade WHERE ra_aluno = $ra_aluno";
        $row = $this->db->query($sql)->row();
        return $row->total_atividades;
    }
    
    function delete($ra_aluno){
        $sql = "DELETE FROM aluno WHERE ra = $ra_aluno";
        return $this->db->query($sql);
    }
    
    function delete_atividades($ra_aluno){
        $sql = "DELETE FROM atividade WHERE ra_aluno = $ra_aluno";
        return $this->db->query($sql);
    }

    function delete_atividades_tem_certificado($ra_aluno){
        $sql = "DELETE FROM atividade_tem_certificado WHERE ra_aluno = $ra_aluno";
        return $this->db->query($sql);
    }
    
    function senhaExiste($ra,$senha){
        $sql = "SELECT ra,senha FROM aluno WHERE ra = '$ra' AND senha = '$senha'";
        return $this->db->query($sql)->row();
    }
    
    function atualizarSenha($ra,$senha){
        $sql = "UPDATE aluno SET senha = '$senha' WHERE ra = '$ra'";
        return $this->db->query($sql);
    }
    
    function updateSenhaTemporaria($email,$senha_temporaria){
        $sql = "UPDATE aluno SET senha_temporaria='$senha_temporaria' WHERE email='$email'";
        return $this->db->query($sql);
    }
    
    function senhaTempExiste($email,$senha){
        $sql = "SELECT senha_temporaria FROM aluno WHERE email='$email' AND senha_temporaria = '$senha'";
        return $this->db->query($sql)->row();
    }
    
}
