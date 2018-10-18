<?php

class Mod_certificado extends CI_Model {
    
    function getAllSelect2(){
        $sql = "SELECT id_certificado, nome_certificado FROM certificado ORDER BY nome_certificado ASC";
        return $this->db->query($sql)->result();
    }

    function getCertificadoByAtividade($id_atividade,$id_certificado){
        $sql = "SELECT * FROM atividade_tem_certificado WHERE id_atividade = '$id_atividade' AND id_certificado = '$id_certificado'";
        return $this->db->query($sql)->row();
    }
    
    function getByAtividade($id_atividade){
        $sql = "SELECT * FROM atividade_tem_certificado WHERE id_atividade = '$id_atividade'";
        return $this->db->query($sql)->row();
    }
}
