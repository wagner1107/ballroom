<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
        $this->load->model('Login_model');
		
	}

    public function index(){
        echo json_encode(array("status" => false, "Description" => "Você precisa estar logado para acessar essa rota"));exit;
    }

    public function login(){
		
		if( isset($_POST['email']) && $_POST['email'] != null 
			&& isset($_POST['password']) && $_POST['password'] != null){

			$email = addslashes($_POST['email']);
			$pass = addslashes(md5($_POST['password']));

			$usuario_cadastrado = $this->Login_model->loginFornecedor($email, $pass);

			if( $usuario_cadastrado == false || !is_object($usuario_cadastrado[0] ) ){
				echo json_encode(array( "status" => false, "Fornecedores" => "Dados Incorretos ou login inativo")); exit;
			};

			$dados['email'] = $usuario_cadastrado[0]->email;
			$dados['id'] = $usuario_cadastrado[0]->id;

			$this->session->set_userdata($dados);

			echo json_encode(array( "status" => true, "Fornecedores" => $dados['email'] . " - Logado com sucesso ")); exit;

		}
		
	}

    public function logout(){
        $this->session->sess_destroy();
    }

    public function cadastrar(){

		if( isset($_POST['email']) && $_POST['email'] != null && isset($_POST['password']) && $_POST['password'] != null ) {

			$dados['email'] = addslashes($_POST['email']);
			$dados['password'] = addslashes(md5($_POST['password']));
			$dados['created_at'] = date('Y-m-d H:i:s');
			
			if(!$this->validarCadastro("tb_provider_login" , "email", $dados['email'])){
				echo json_encode(array( "status" => true, "id_provider" => $this->Login_model->cadastrar("tb_provider_login", $dados))); exit;
			} else {
				echo json_encode(array("status" => false, "description" => "Email ja cadastrado em nosso sistema")); exit;
			}

		} else {
			echo json_encode(array("status" => false, "description" => "Envie e-mail e senha corretamente")); exit;
		}
	
	}

	public function buscar(){

		$id = $this->session->userdata('id');

		if(empty($id)){
			redirect("login/index");
		}
		
		echo json_encode(array( "status" => true, "Fornecedores" => $this->Login_model->buscar($id))); exit;
	}

	public function deletar(){
		
        $id = $this->session->userdata('id');

		if(empty($id)){
			redirect("login/index");
		}

        if($this->Login_model->buscar($id)){
            echo json_encode(array("status" => $this->Login_model->deletar($id, array("deleted_at" => date("Y-m-d H:m:s"))), "description" => "Login exlcuido com sucesso" ));
		} else {
			echo json_encode(array("status" => false, "description" => "Por favor, enviar o e-mail para realizar a exclusao"));
		} 
	}

	public function validarCadastro($tabela, $campo, $valor){
		return $this->Login_model->validarCadastro($tabela, $campo, $valor);
	}

}