<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}

    public function loginFornecedor($email, $pass){
        $this->db->select("*");
        $this->db->from('tb_provider_login');
        $this->db->where("email", $email);
        $this->db->where("password", $pass);
        $this->db->where("deleted_at", NULL);

        $query = $this->db->get();

        if($query->num_rows() >= 1){
            return $query->result();
        }
        return false;
    }

    public function validarCadastro($tabela, $campo, $valor){

        $this->db->where($campo, $valor);
        $query = $this->db->get($tabela);

        if($query->num_rows() >= 1){
            return  $query->result();
        }
        return false;
    }

    public function cadastrar($tabela, $dados){
        $this->db->insert($tabela, $dados);
        return $this->db->insert_id();
    }
    
    public function buscar($id){
        $this->db->select("tb_provider_login.id");
        $this->db->select("tb_provider_login.email");
        $this->db->select("tb_provider_bank.bank");
        $this->db->select("tb_provider_bank.agency");
        $this->db->select("tb_provider_bank.account");
        $this->db->select("tb_provider_bank.account_digit");
        $this->db->select("tb_provider_bank.type_account");
        $this->db->from("tb_provider_login");
        $this->db->join("tb_provider_bank", "tb_provider_bank.id_provider_login = tb_provider_login.id");
        $this->db->where('tb_provider_login.id', $id);
        $this->db->where('tb_provider_bank.deleted_at', NULL);

        $query = $this->db->get();
        
        if($query->num_rows() >= 1){
            return $query->result();
        }
        return false;
    }

    public function deletar($id, $dados){

        $this->db->where('id', $id);
        $this->db->update("tb_provider_login", $dados);

        return true;
    }

}