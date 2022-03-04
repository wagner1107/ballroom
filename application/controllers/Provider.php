<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provider extends CI_Controller {

	function __construct(){
		parent::__construct();
        $this->load->model('Provider_model');
		
	}

	public function index(){
		echo "Voce precisa realizar o login na rota loginFornecedores ";
	}

	private function validarCadastro($tabela, $campo, $valor){
		return $this->Provider_model->validarCadastro($tabela, $campo, $valor);
	}

	public function buscar(){

		$user = $this->session->userdata('email');


		if(empty($user)){
			redirect("provider/index");
		}
		
		$email = null;
		if(isset($_POST['email']) && $_POST['email'] != null ){
			$email = addslashes($_POST['email']);
		}
		
		echo json_encode(array( "status" => true, "Fornecedores" => $this->Provider_model->buscar("tb_provider_login", "email", $email, true ))); exit;
	}

	public function cadastrar(){

		if( isset($_POST['email']) && $_POST['email'] != null && isset($_POST['password']) && $_POST['password'] != null ) {

			$dados['email'] = addslashes($_POST['email']);
			$dados['password'] = addslashes(md5($_POST['password']));
			$dados['created_at'] = date('Y-m-d H:i:s');
			
			if(!$this->validarCadastro("tb_provider_login" , "email", $dados['email'])){
				echo json_encode(array( "status" => true, "id_provider" => $this->Provider_model->cadastrar("tb_provider_login", $dados))); exit;
			} else {
				echo json_encode(array("status" => false, "description" => "Email ja cadastrado em nosso sistema")); exit;
			}

		} else {
			echo json_encode(array("status" => false, "description" => "Envie e-mail e senha corretamente")); exit;
		}
	
	}

	public function deletar(){

		if( isset($_POST['email']) ){
		
			$condicao = addslashes($_POST['email']);

			if($this->Provider_model->buscar('tb_provider_login', 'email', $condicao)){
				echo json_encode(array("status" => $this->Provider_model->deletar('tb_provider_login', 'email', $condicao, array("deleted_at" => date("Y-m-d H:m:s")))));
			}
		} else {
			echo json_encode(array("status" => false, "description" => "Por favor, enviar o e-mail para realizar a exclusao"));
		} 
	}

	public function cadastrarDados(){

		if(  isset($_POST['email']) && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['document']) ) {
			
			$email = addslashes($_POST['email']);

			$dados['name'] = addslashes($_POST['name']);
			$dados['description'] = addslashes($_POST['description']);
			$dados['document'] = addslashes($_POST['document']);
			$dados['id_provider_login'] = is_object($this->validarCadastro("tb_provider_login" , "email", $email)[0]) ? $this->validarCadastro("tb_provider_login" , "email", $email)[0]->id : 0 ;

			if($dados['id_provider_login'] > 0){
				echo json_encode(array("status" => true, "id_provider_data" => $this->Provider_model->cadastrarDados($dados))); exit;
			} else {
				echo json_encode(array("status" => false, "description" => "E-mail nao cadastrado no sistema")); exit;
			}

		} else {
			echo json_encode(array("status" => false, "description" => "Envie os dados de Email, Nome, Descricao e Documento para seguirmos com a atualizacao cadastral")); exit;
		}


	}

	public function deletarDados(){

		if( isset($_POST['documento']) ){
		
			$documento = addslashes($_POST['documento']);

			if($this->Provider_model->buscar('tb_provider_data', 'document' ,$documento)){
				echo json_encode(array("status" => $this->Provider_model->deletar('tb_provider_data', 'document', $documento, array("deleted_at" => date("Y-m-d H:m:s")))));
			}
		} else {
			echo json_encode(array("status" => false, "description" => "Por favor, enviar o documento para realizar a exclusao"));
		} 
	}

	public function cadastrarDadosBancarios(){

		if(    isset($_POST['banco']) && $_POST['banco'] != null 
			&& isset($_POST['agencia']) && $_POST['agencia'] != null 
			&& isset($_POST['conta']) && $_POST['conta'] != null 
			&& isset($_POST['digito']) && $_POST['digito'] != null 
			&& isset($_POST['tipo']) && $_POST['tipo'] != null 
			&& isset($_POST['email']) &&  $_POST['email'] != null 
			) {
			
			$email = addslashes($_POST['email']);
			
			$dados['bank'] = addslashes($_POST['banco']);
			$dados['agency'] = addslashes($_POST['agencia']);
			$dados['account'] = addslashes($_POST['conta']);
			$dados['account_digit'] = addslashes($_POST['digito']);
			$dados['type_account'] = addslashes($_POST['tipo']);
			$dados['created_at'] = date('Y-m-d H:i:s');
			$dados['id_provider_login'] = is_object($this->validarCadastro("tb_provider_login" , "email", $email)[0]) ? $this->validarCadastro("tb_provider_login" , "email", $email)[0]->id : 0 ;
			
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

	public function loginFornecedor(){
		
		if( isset($_POST['email']) && $_POST['email'] != null 
			&& isset($_POST['password']) && $_POST['password'] != null){

			$email = addslashes($_POST['email']);
			$pass = addslashes(md5($_POST['password']));

			$usuario_cadastrado = $this->Provider_model->loginFornecedor($email, $pass);

			if( !is_object($usuario_cadastrado[0]) ){
				echo json_encode(array( "status" => false, "Fornecedores" => "Dados Incorretos")); exit;
			};


			$dados['email'] = $usuario_cadastrado[0]->email;
			$dados['id'] = $usuario_cadastrado[0]->id;

			$this->session->set_userdata($dados);

			echo json_encode(array( "status" => true, "Fornecedores" => $dados['email'] . " - Logado com sucesso ")); exit;

		}
		
	}

}