<?php

/**
 * Stream.
 *
 * @copyright Krator (Krator)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Krator <kratord@hotmail.com>.
 * @see https://www.heroesofmightandmagic.es/portal/
 * @see https://ziku.la
 * @version Generated by ModuleStudio 1.4.0 (https://modulestudio.de).
 */

namespace Krator\StreamModule\Helper;

use Symfony\Component\HttpFoundation\RequestStack;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\ExtensionsModule\Api\ApiInterface\VariableApiInterface;

/**
 * Helper implementation class for upload handling.
 */
class TwitchHelper
{
    /**
     * @var RequestStack
     */
    protected $requestStack;
    
    /**
     * @var VariableApiInterface
     */
    protected $variableApi;
    
    public function __construct(
        RequestStack $requestStack,
        VariableApiInterface $variableApi
    ) {
        $this->requestStack = $requestStack;
        $this->variableApi = $variableApi;
    }
	
	/**
     * This method returns an App Access Token
     *
     * @return array The selected runtime options
     */
	public function getAccessToken()
	{
		$clientId = $this->variableApi->get('KratorStreamModule', 'clientId');
		if (empty($clientId)){
			//Error
		}
		$clientSecret = $this->variableApi->get('KratorStreamModule', 'clientSecret');
		if (empty($token)){
			//Error
		}

		// Get access token -> TO-DO create a method with this
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://id.twitch.tv/oauth2/token');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
			'client_id' => $clientId,
			'client_secret' => $clientSecret,
			'grant_type' => 'client_credentials'
		]));
		$output = curl_exec($ch);
		curl_close($ch);

		$oauth = json_decode($output, true);
		
		$this->variableApi->set('KratorStreamModule', 'appToken', $oauth['access_token']);
		
		return $oauth['access_token'];
	}
	
	/**
     * This method returns an App Access Token refreshed
     *
     * @return array The selected runtime options
     */
	public function refreshAccessToken()
	{
		$clientId = $this->variableApi->get('KratorStreamModule', 'clientId');
		if (empty($clientId)){
			//Error
		}
		$clientSecret = $this->variableApi->get('KratorStreamModule', 'clientSecret');
		if (empty($token)){
			//Error
		}
		$token = $this->variableApi->get('KratorStreamModule', 'appToken');
		if (empty($token)){
			//Error
		}
		// Get access token -> TO-DO create a method with this
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://id.twitch.tv/oauth2/token');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
			'client_id' => $clientId,
			'client_secret' => $clientSecret,
			'refresh_token' => $token,
			'grant_type' => 'refresh_token'
		]));
		$output = curl_exec($ch);
		curl_close($ch);

		$oauth = json_decode($output, true);
		//Check response
		/*if (isset($oauth->status) && $oauth->status == 400){
			//Generate token
			$this->getAccessToken();
		} else {
			$this->variableApi->set('KratorStreamModule', 'appToken', $oauth['refresh_token']);
		}*/
		if (isset($oauth['refresh_token'])){
			$this->variableApi->set('KratorStreamModule', 'appToken', $oauth['refresh_token']);
		} else {
			//Generate token
			$this->getAccessToken();
		}

	}

	/*
	* Get streams of a game
	*/
	public function getStreamsByGameId($gameId, $language = null, $limit = 20)
	{
		$clientId = $this->variableApi->get('KratorStreamModule', 'clientId');
		if (empty($clientId)){
			//Error
		}
		$token = $this->variableApi->get('KratorStreamModule', 'appToken');
		if (empty($token)){
			//Generar App Token
			$token = $this->getAccessToken();
		}

		$url = 'https://api.twitch.tv/helix/streams?game_id=' . $gameId;
		if (isset($language) && $language != ""){
			$url = $url . '&language=' . $language;
		}
		if (isset($limit)){
			$url = $url . '&first='. $limit;
		}

		$gStreams = curl_init();
 
		curl_setopt_array($gStreams, array(
			CURLOPT_HTTPHEADER => array(
			   'Client-ID: ' . $clientId,
			   'Authorization: Bearer ' . $token
			),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_URL => $url 
		));

		$response = curl_exec($gStreams);
		curl_close($gStreams);

		$json_decode = json_decode($response);
		//Check response
		if (isset($json_decode->status) && $json_decode->status == 401){
			//Refresh token
			$this->refreshAccessToken();
			//And try again - ¡¡ POSSIBLE INFINITE LOOP !!
			$this->getStreamsByGameId($gameId);
		}
		return $json_decode->data;
	}
	
	/*
	* Get information about a game
	*/
	public function searchGame($search)
	{
		// Get variables
		$clientId = $this->variableApi->get('KratorStreamModule', 'clientId');
		if (empty($clientId)){
			//Error
			$founds = array();
		}
		$token = $this->variableApi->get('KratorStreamModule', 'appToken');
		if (empty($token)){
			//Generate App Token
			$token = $this->getAccessToken();
		}

		// Api Twitch Game: https://dev.twitch.tv/docs/api/reference#get-games
		$url = 'https://api.twitch.tv/helix/games?name='.rawurlencode($search);

		$gStreams = curl_init();
 
		curl_setopt_array($gStreams, array(
			CURLOPT_HTTPHEADER => array(
			   'Client-ID: ' . $clientId,
			   'Authorization: Bearer ' . $token
			),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_URL => $url 
		));

		$response = curl_exec($gStreams);
		if ($response === false){
			//Try again
			$response = curl_exec($gStreams);
			if ($response === false){
				$founds = array();
			}
		}
		curl_close($gStreams);

		$json_decode = json_decode($response);
		if (!empty($json_decode)){
			$founds = $json_decode->data;
		}else{
			$founds = array();
		}
		
		return $founds;
	}
}
