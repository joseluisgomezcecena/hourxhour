<?php

class Mail_Alerts extends CI_Controller
{


	public function test_mail()
	{
		$this->load->library('email');

		$subject = 'This is a test';
		$message = '<p>This message has been sent for testing purposes.</p>';

		$body = $this->email->full_html($subject, $message);


		$result = $this->email
			->from('jgomez@martechmedical.com')
			->reply_to('jgomez@martechmedical.com')    // Optional, an account where a human being reads.
			->to('jgomez@martechmedical.com')
			->subject($subject)
			->message($body)
			->send();

		var_dump($result);
		echo '<br />';
		echo $this->email->print_debugger();

		exit;

	}



	public function send_daily_report()
	{

	}


}
