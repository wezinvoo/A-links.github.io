<?php
/**
 * =======================================================================================
 *                           GemFramework (c) GemPixel                                     
 * ---------------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework as such distribution
 *  or modification of this framework is not allowed before prior consent from
 *  GemPixel. If you find that this framework is packaged in a software not distributed 
 *  by GemPixel or authorized parties, you must not use this software and contact gempixel
 *  at https://gempixel.com/contact to inform them of this misuse.
 * =======================================================================================
 *
 * @package GemPixel\Premium-URL-Shortener
 * @author GemPixel (https://gempixel.com) 
 * @license https://gempixel.com/licenses
 * @link https://gempixel.com  
 */

namespace Helpers;

class Slack {

	/**
	 * Slack Client ID
	 * @var null
	 */
	private $clientID = NULL;

	/**
	 * Slack Client Secret
	 * @var null
	 */
	private $clientSecret = NULL;

	/**
	 * Redirect URI
	 * @var null
	 */
	private $redirectURI = NULL;

	/**
	 * Slack API Constant
	 */
	const slackURI = "https://slack.com/api";
	/**
	 * Constructor
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 */
	public function __construct($clientID, $clientSecret, $redirectURI){

		$this->clientID = $clientID;
		$this->clientSecret = $clientSecret;
		$this->redirectURI = $redirectURI;

	}
	/**
	 * [process description]
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
	public function process(){
		if(isset($_GET["code"])){
			if($access = $this->http("oauth.access", ["code" => $_GET["code"], "client_id" => $this->clientID, "client_secret" => $this->clientSecret, "redirect_uri" => $this->redirectURI])){
				return $access->user_id;
			}			
		}
		return false;
	}
	/**
	 * [validate description]
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 * @param   [type] $signing_secret [description]
	 * @return  [type]                 [description]
	 */
	public static function validate($signing_secret){

		if(isset($_SERVER["HTTP_X_SLACK_REQUEST_TIMESTAMP"]) && isset($_SERVER["HTTP_X_SLACK_SIGNATURE"])){

			$timestamp = $_SERVER["HTTP_X_SLACK_REQUEST_TIMESTAMP"];
			$sig = $_SERVER["HTTP_X_SLACK_SIGNATURE"];
			$input = file_get_contents("php://input");

			$validation = "v0:{$timestamp}:{$input}";

			if("v0=".hash_hmac("sha256", $validation, $signing_secret) == $_SERVER["HTTP_X_SLACK_SIGNATURE"]){
				return true;
			}
		}

		return false;
	}
	/**
	 * [error description]
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
	public function error(){
		if(isset($_GET["error"])){
			$errors = [
				"access_denied" => e("You need to allow this application to install the commands on your slack account."),
				"error" => e("Something went wrong, please try again."),
			];
			if(isset($errors[$_GET["error"]])) return $errors[$_GET["error"]];			
			return $errors["error"];		
		}
		return false;
	}
	/**
	 * [redirect description]
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
	public function redirect(){
		header("Location: https://slack.com/oauth/authorize?scope=commands&client_id={$this->clientID}&redirect_uri={$this->redirectURI}");
		exit;
	}
	/**
	 * Generate Authentication Button
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
	public function generateAuth(){
		return '<a href="'.$this->redirectURI.'"><img alt="Add to Slack" height="40" width="139" src="https://platform.slack-edge.com/img/add_to_slack.png" srcset="https://platform.slack-edge.com/img/add_to_slack.png 1x, https://platform.slack-edge.com/img/add_to_slack@2x.png 2x" /></a>';
	}
	/**
	 * [http description]
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 * @param   array  $data [description]
	 * @return  [type]       [description]
	 */
  private function http($endpoint, array $data){

    $parameters = http_build_query($data);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, self::slackURI."/".$endpoint);
    curl_setopt($curl, CURLOPT_POST, count($data));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $parameters);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($curl);

    if($error = curl_error($curl)){
    	error_log($error);
    }

    curl_close($curl);        
    return json_decode($response);
  }	

}