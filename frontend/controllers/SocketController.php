<?php

namespace frontend\controllers;

use frontend\models\ChatHandler;

class SocketController extends \yii\web\Controller
{
    /*public function actionIndex()
    {
		$null = NULL;
		$chatHandler = new ChatHandler();
		//echo "ааа=" . $chatHandler::PORT;die;

		$socketResource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		socket_set_option($socketResource, SOL_SOCKET, SO_REUSEADDR, 1);
		socket_bind($socketResource, 0, $chatHandler::PORT);
		socket_listen($socketResource);

		$clientSocketArray = array($socketResource);
		while (true) {
			$newSocketArray = $clientSocketArray;
			socket_select($newSocketArray, $null, $null, 0, 10);
			
			if (in_array($socketResource, $newSocketArray)) {
				$newSocket = socket_accept($socketResource);
				$clientSocketArray[] = $newSocket;
				
				$header = socket_read($newSocket, 1024);
				$chatHandler->doHandshake($header, $newSocket, $chatHandler::HOST_NAME, $chatHandler::PORT);
				
				socket_getpeername($newSocket, $client_ip_address);
				$connectionACK = $chatHandler->newConnectionACK($client_ip_address);
				
				$chatHandler->send($connectionACK);
				
				$newSocketIndex = array_search($socketResource, $newSocketArray);
				unset($newSocketArray[$newSocketIndex]);
			}
			
			foreach ($newSocketArray as $newSocketArrayResource) {	
				while(socket_recv($newSocketArrayResource, $socketData, 1024, 0) >= 1){
					$socketMessage = $chatHandler->unseal($socketData);
					$messageObj = json_decode($socketMessage);
					
					$chat_box_message = $chatHandler->createChatBoxMessage($messageObj->chat_user, $messageObj->chat_message);
					$chatHandler->send($chat_box_message);
					break 2;
				}
				
				$socketData = @socket_read($newSocketArrayResource, 1024, PHP_NORMAL_READ);
				if ($socketData === false) { 
					socket_getpeername($newSocketArrayResource, $client_ip_address);
					$connectionACK = $chatHandler->connectionDisconnectACK($client_ip_address);
					$chatHandler->send($connectionACK);
					$newSocketIndex = array_search($newSocketArrayResource, $clientSocketArray);
					unset($clientSocketArray[$newSocketIndex]);			
				}
			}
		}
		socket_close($socketResource);
    }*/
}
