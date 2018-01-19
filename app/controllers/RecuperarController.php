<?php

class RecuperarController extends \HXPHP\System\Controller
{
	public function __construct($configs)
	{
		parent::__construct($configs);

		$this->load(
			'Services\Auth',
			$configs->auth->after_login,
			$configs->auth->after_logout,
			true
		);

		$this->auth->redirectCheck(true);

		$this->view->setTitle('SistemaHX - Altere sua senha');

		$this->load('Modules\Messages', 'password-recovery');
		$this->messages->setBlock('alerts');
	}

	public function solicitarAction()
	{
		$this->view->setFile('index');

		$this->request->setCustomFilters(array(
			'email' => FILTER_VALIDATE_EMAIL
		));

		$email = $this->request->post('email');

		$error = null;

		if (!is_null($email) && $email !== false) {
			$validar = Recovery::validar($email);

			if ($validar->status === false) {
				$error = $this->messages->getByCode($validar->code);
			}
			else {
				$this->load(
					'Services\PasswordRecovery',
					$this->configs->site->url . $this->configs->baseURI . 'recuperar/redefinir/'
				);

				Recovery::create(array(
					'user_id' => $validar->user->id,
					'token' => $this->passwordrecovery->token,
					'status' => 0
				));

				$message = $this->messages->messages->getByCode('link-enviado', array(
					'message' => array(
						$validar->user->name,
						$this->passwordrecovery->link,
						$this->passwordrecovery->link
					)
				));

				$this->load('Services\Email');

				$envioDoEmail = $this->email->send(
					$validar->user->email,
					'HXPHP - ' . $message['subject'],
					$message['message'] . 'HXPHP',
					array(
						'email' => $this->configs->mail->from_mail,
						'remetente' => $this->configs->mail->from 
					)
				);

				if ($envioDoEmail === false) {
					$error = $this->messages->getByCode('email-nao-enviado');
				}
			}
		}
		else {
			$error = $this->messages->getByCode('nenhum-usuario-encontrado');
		}

		if (!is_null($error)) {
			$this->load('Helpers\Alert', $error);
		}
		else {
			$success = $this->messages->getByCode('link-enviado');

			$this->view->setFile('blank');

			$this->load('Helpers\Alert', $success);
		}
	}

	public function redefinirAction($token)
	{
		$validarToken = Recovery::validarToken($token);

		$error = null;

		if ($validarToken->status === false) {
			$error = $this->messages->getByCode($validarToken->code);
		}
		else {
			$this->view->setVar('token', $token);
		}

		if ( ! is_null($error)) {
			$this->view->setFile('blank');
			$this->load('Helpers\Alert', $error);
		}
	}

	public function alterarSenhaAction($token)
	{
		$this->view->setFile('redefinir');

		$validarToken = Recovery::validarToken($token);

		$error = null;

		if ($validarToken->status === false) {
			$this->view->setFile('blank');
			$error = $this->messages->getByCode($validarToken->code);
		}
		else {
			$this->view->setVar('token', $token);
			$password = $this->request->post('password');

			if ( ! is_null($password)) {
				$atualizarSenha = User::atualizarSenha($validarToken->user, $password);

				if ($atualizarSenha === true) {
					Recovery::limpar($validarToken->user->id);

					$this->view->setPath('login')
								->setFile('index');

					$success = $this->messages->getByCode('senha-redefinida');

					$this->load('Helpers\Alert', $success);
				}
			}
		}

		if ( ! is_null($error))
			$this->load('Helpers\Alert', $error);
	}
	
}