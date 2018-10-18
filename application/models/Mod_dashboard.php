<?php

class Mod_dashboard extends CI_Model {

    function converterData($data)
    {
    	$data_tmp = explode('/',$data);
    	$d_data = $data_tmp[0];
    	$m_data = $data_tmp[1];
    	$y_data = $data_tmp[2];
    	return $y_data.'-'.$m_data.'-'.$d_data;
    }    
    
    function inserirAviso($dados){
        $sql = "INSERT INTO aviso (data_aviso,titulo_aviso,aviso) VALUES (?,?,?)";
        return $this->db->query($sql,$dados);
    }

    function getAllAvisos(){
        $sql = "SELECT * FROM aviso ORDER BY data_aviso DESC, titulo_aviso";
        return $this->db->query($sql)->result();
    }

    function delete($id_aviso){
        $sql = "DELETE FROM aviso WHERE id = $id_aviso";
        return $this->db->query($sql);
    }
    
    function getConfig(){
        $sql = "SELECT * FROM config WHERE id = 'default'";
        return $this->db->query($sql)->row();
    }
    
    function updateConfig($dados){
        if($dados['assinatura']==''){
            $newDados = ['nome_diretor'=>$dados['nome_diretor'],'limite_atividade'=>$dados['limite_atividade'],'id'=>$dados['id']];
            $sql = "UPDATE config SET nome_diretor=?,limite_atividade=? WHERE id=?";
        }else{
            $newDados = ['assinatura'=>$dados['assinatura'],'nome_diretor'=>$dados['nome_diretor'],'limite_atividade'=>$dados['limite_atividade'],'id'=>$dados['id']];
            $sql = "UPDATE config SET assinatura=?,nome_diretor=?,limite_atividade=? WHERE id=?";
        }
        return $this->db->query($sql,$newDados);
    }
    
    function getAll(){
        $sql = "SELECT * FROM config WHERE id = 'default'";
        return $this->db->query($sql)->row();
    }
    
}
