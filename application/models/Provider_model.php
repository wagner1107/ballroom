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

    public function cadastrar($tabela, $dados){
        $this->db->insert($tabela, $dados);
        return $this->db->insert_id();
    }

    public function deletar($tabela, $campo, $condicao, $dados){

        $this->db->where($campo, $condicao);
        $this->db->update($tabela, $dados);

        return true;
    }

    public function buscar($tabela, $campo, $condicao = null, $join = null ){
        $this->db->select("*");
        $this->db->from($tabela);

        if($join != null){
            $this->db->join("tb_provider_data", "tb_provider_data.id_provider_login = tb_provider_login.id", "left");
            $this->db->join("tb_provider_bank", "tb_provider_bank.id_provider_login = tb_provider_login.id","left");
        }
        
        if($condicao != null ){
            $this->db->where($campo, $condicao);
        }
        $query = $this->db->get();

        if($query->num_rows() >= 1){
            return $query->result();
        }
        return false;
    }

    public function cadastrarDados($dados){

        $this->db->select("*");
        $this->db->from('tb_provider_data');
        $this->db->where('id_provider_login', $dados['id_provider_login']);
        $query = $this->db->get();

        if($query->num_rows() >= 1){
            $this->db->where('id_provider_login', $dados['id_provider_login']);
            $this->db->update('tb_provider_data', $dados);
            return true;
        } else {
            $this->db->insert('tb_provider_data', $dados);
            return $this->db->insert_id();
        }
    }

    public function cadastrarDadosBancarios($dados){

        $this->db->where('account', $dados['account']);
        $query = $this->db->get('tb_provider_bank');

        if($query->num_rows() >= 1){

            $this->db->where('account', $dados['account']);
            $this->db->update('tb_provider_bank', $dados);
            return true;
        } else {
            $this->db->insert('tb_provider_bank', $dados);
            return $this->db->insert_id();
        }
    }

}