<?php namespace App\Controller;

use App\Entity\Email;
use App\Form\Type\EmailType;
use App\Mail\Notifier;
use Symfony\Component\HttpFoundation\Request;

class EmailController extends Controller {

	public function newAction(Request $request, $username) {
		$senderUser = $this->getUser();
		if ($senderUser->isAnonymous()) {
			return array('message' => 'stop_anon');
		}
		if (!$senderUser->hasEmail()) {
			return array('message' => 'stop_no_email', 'sender' => $senderUser);
		}

		$recipientUser = $this->em()->getUserRepository()->findByUsername($username);
		if (!$recipientUser) {
			throw $this->createNotFoundException("Не съществува потребител с име $username.");
		}
		if (!$recipientUser->allowsEmail()) {
			return array('message' => 'stop_email_not_allowed', 'recipient' => $recipientUser);
		}

		$email = new Email($recipientUser, $senderUser);
		$form = $this->createForm(new EmailType(), $email);

		if ($form->handleRequest($request)->isValid()) {
			$notifier = new Notifier($this->get('mailer'));
			$notifier->sendPerMail($email, $email->getRecipient());
			return $this->redirectWithNotice('Писмото ви беше изпратено.');
		}

		return array(
			'form' => $form->createView(),
			'sender' => $senderUser,
			'recipient' => $recipientUser,
		);
	}
}