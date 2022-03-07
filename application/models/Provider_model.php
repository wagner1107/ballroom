<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provider_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}

    public function validarCadastro($tabela, $campo, $valor){

        $this->db->where($campo, $valor);
        $query = $this->db->get($tabela);

        if($query->num_rows() >= 1){
            return  $query->result();
        }
        return false;
    }

    public function deletarDados($tabela, $campo, $condicao, $dados){

        $this->db->where($campo, $condicao);
        $this->db->update($tabela, $dados);

        return true;
    }

    public function cadastrarDados($dados){

        $this->db->select("*");
        $this->db->from('tb_provider_data');
        $this->db->where('id_provider_login', $dados['id_provider_login']);
        $this->db->where('deleted_at', null);
        $query = $this->db->get();

        if($query->num_rows() >= 1){
            $this->db->where('id_provider_login', $dados['id_provider_login']);
            $this->db->where('deleted_at', null);
            $this->db->update('tb_provider_data', $dados);
            return true;
        } else {
			$dados['created_at'] = date("Y-m-d H:i:s");
            $this->db->insert('tb_provider_data', $dados);
            return $this->db->insert_id();
        }
    }

    public function buscar($id){

        $this->db->where('tb_provider_login.id', $id);

        $query = $this->db->get();
        
        if($query->num_rows() >= 1){
            return $query->result();
        }
        return false;
    }

    public function cadastrarDadosBancarios($dados){

        $this->db->where('account', $dados['account']);
        $this->db->where('deleted_at', null);
        $query = $this->db->get('tb_provider_bank');

        if($query->num_rows() >= 1){
            $this->db->where('account', $dados['account']);
            $this->db->where('deleted_at', null);
            $this->db->update('tb_provider_bank', $dados);
            return true;
        } else {
			$dados['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('tb_provider_bank', $dados);
            return $this->db->insert_id();
        }
    }



}