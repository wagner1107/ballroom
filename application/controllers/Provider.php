<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
Esse controller possui CRUD do Fornecedor
*/

class Provider extends CI_Controller {

	public int $id  = 10;
	public string $email;

	function __construct(){
		parent::__construct();
        $this->load->model('Provider_model');
        $this->load->model('Login_model');

		$this->id = $this->session->userdata('id');
		$this->email = $this->session->userdata('email');


		if(empty($this->id)&& empty($this->email)){
			redirect("login/index");
		}
	}

	public function cadastrarDados(){

		if( $_POST['document'] != NULL && isset($_POST['document'])
 			&& $_POST['name'] != NULL && isset($_POST['name'])
 			&& $_POST['description'] != NULL && isset($_POST['description'])
		) {
			
			$dados['name'] = addslashes($_POST['name']);
			$dados['description'] = addslashes($_POST['description']);
			$dados['document'] = addslashes($_POST['document']);
			$dados['id_provider_login'] = $this->id;

			if($dados['id_provider_login'] > 0){
				echo json_encode(array("status" => true, "id_provider_data" => $this->Provider_model->cadastrarDados($dados))); exit;
			} else {
				echo json_encode(array("status" => false, "description" => "E-mail nao cadastrado no sistema")); exit;
			}

		} else {
			echo json_encode(array("status" => false, "description" => "Envie os dados de Nome, Descricao e Documento para seguirmos com a atualizacao cadastral")); exit;
		}


	}

	public function deletarDados(){
		echo json_encode(array("status" => $this->Provider_model->deletarDados('tb_provider_data', 'id_provider_login', $this->id, array("deleted_at" => date("Y-m-d H:m:s")))));
	}

	public function cadastrarDadosBancarios(){

		if(    isset($_POST['banco']) && $_POST['banco'] != null 
			&& isset($_POST['agencia']) && $_POST['agencia'] != null 
			&& isset($_POST['conta']) && $_POST['conta'] != null 
			&& isset($_POST['digito']) && $_POST['digito'] != null 
			&& isset($_POST['tipo']) && $_POST['tipo'] != null 
			) {
			
			$email = addslashes($_POST['email']);
			
			$dados['bank'] = addslashes($_POST['banco']);
			$dados['agency'] = addslashes($_POST['agencia']);
			$dados['account'] = addslashes($_POST['conta']);
			$dados['account_digit'] = addslashes($_POST['digito']);
			$dados['type_account'] = addslashes($_POST['tipo']);
			$dados['id_provider_login'] = $this->id;
			
			if($dados['id_provider_login'] > 0){
				echo json_encode(array( "status" => true, "id_provider" => $this->Provider_model->cadastrarDadosBancarios($dados))); exit;
			} else {
				echo json_encode(array("status" => false, "description" => "E-mail invalido")); exit;
			}

		} else {
			echo json_encode(array("status" => false, "description" => "Envie os dados bancarios corretamente")); exit;
		}
	
	}

	public function deletarDadosBancarios(){

		if( isset($_POST['conta']) ){
		
			$conta = addslashes($_POST['conta']);

			if($this->Provider_model->buscar('tb_provider_bank', 'account' ,$conta)){
				echo json_encode(array("status" => $this->Provider_model->deletar('tb_provider_bank', 'account', $conta, array("deleted_at" => date("Y-m-d H:m:s")))));
			}
		} else {
			echo json_encode(array("status" => false, "description" => "Por favor, enviar o numeoro da conta para realizar a exclusao"));
		} 
	}

	
}