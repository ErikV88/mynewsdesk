<?php

/**
 * Soap short summary.
 *
 * Soap description.
 *
 * @version 1.0
 * @author User
 */
class Soap
{
	var $client; // = new SoapClient("http://example.com/webservices?wsdl");
	var $isAuthed=false;
	var $secret =null;

	public function __construct($pUrl) {
		 $this->client = new SoapClient($pUrl);
	}

	public function Login($pUsername,$pPassword)
	{
		$ret = $this->client->performLogin($pUsername,$pPassword);

		// Validate result
		switch ($ret["result"]) {
			case "login_ok":
				$this->secret = $ret["secret"]; // You might want to store this in a session or cache as it can be used many times.
				$this->isAuthed=true;
				break;
			case "login_failure":
				echo "Invalid credentials. Login failed\n";
				$this->secret=null;
				$this->isAuthed=false;
				break;
			case "twofactor_required":
				// This user has two factor authentication set.
				// Make a call to request the code by SMS and then perform a two factor login
				echo "Two factor login. Not implemented .\n";
				$this->secret=null;
				$this->isAuthed=false;
				break;
			default:
				echo "Unexcepted return value: {$ret["result"]}\n";
				$this->secret=null;
				$this->isAuthed=false;
				break;
		}
		return $this->secret;
	}

	public function Call($pMethodname,$pParams)
	{
		$response = $this->client->__soapCall($pMethodname, array($pParams));

		return $response;
	}
}