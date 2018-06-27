<?php

/**
 * API Client
 *
 * A simple class designed to retrieve and set values ​​from/to REST API
 *
 * @version 1.0
 * @author Erik Skagen Vindenes
 */
class RestAPIClient
{
	public function Get($pUrl,$pData)
	{
		return $this->Call("GET",$pUrl,$pData);
	}

	public function Post($pUrl,$pData)
	{
		return $this->Call("POST",$pUrl,$pData);
	}

	public function Put($pUrl,$pData)
	{
		return $this->Call("PUT",$pUrl,$pData);
	}

	public function Delete($pUrl,$pData)
	{
		return $this->Call("DELETE",$pUrl,$pData);
	}

	// Method: POST, PUT, GET etc
	// Data: array("param" => "value") ==> index.php?param=value
	//pUser-> Typeof <nullable>UserAuth
	private function Call($pMethod, $pUrl, $pData = false,$pUser=null)
	{
		$vCurl = curl_init();

		switch (strtoupper($pMethod))
		{
			case "POST":
				curl_setopt($vCurl, CURLOPT_POST, 1);

				if ($pData)
					curl_setopt($vCurl, CURLOPT_POSTFIELDS, $pData);
				break;
			case "PUT":
				curl_setopt($vCurl, CURLOPT_PUT, 1);
				break;
			case "DELETE":
				curl_setopt($vCurl, CURLOPT_CUSTOMREQUEST, "DELETE");
				break;
			default:
				if ($pData)
					$pUrl = sprintf("%s?%s", $pUrl, http_build_query($pData));
		}

		// Optional Authentication:
		if($pUser!=null)
		{
			curl_setopt($vCurl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($vCurl, CURLOPT_USERPWD, "$pUser->username:$pUser->password");
		}

		curl_setopt($vCurl, CURLOPT_URL, $pUrl);
		curl_setopt($vCurl, CURLOPT_RETURNTRANSFER, 1);

		$vResult = curl_exec($vCurl);

		curl_close($vCurl);

		return $vResult;
	}

	/* -- Some extra functon if needed to extend headers -- */
	public function LoginWithBasicAuth($pHost,$pUserName,$pPassword, $pAdditionalHeaders,$pPayloadName) {
		$vProcess = curl_init($pHost);
		curl_setopt($vProcess, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', $pAdditionalHeaders));
		curl_setopt($vProcess, CURLOPT_HEADER, 1);
		curl_setopt($vProcess, CURLOPT_USERPWD, $pUserName . ":" . $pPassword);
		curl_setopt($vProcess, CURLOPT_TIMEOUT, 30);
		curl_setopt($vProcess, CURLOPT_POST, 1);
		curl_setopt($vProcess, CURLOPT_POSTFIELDS, $pPayloadName);
		curl_setopt($vProcess, CURLOPT_RETURNTRANSFER, TRUE);
		$vReturn = curl_exec($vProcess);
		curl_close($vProcess);

		return $vReturn;
	}
}