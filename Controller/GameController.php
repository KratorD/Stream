<?php

namespace Krator\StreamModule\Controller;

use Zikula\Bundle\CoreBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Krator\StreamModule\Entity\StreamEntity;
use Krator\StreamModule\Helper\TwitchHelper;

class GameController extends AbstractController
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

		// Get game list
        $streamEntities = $em->getRepository('KratorStreamModule:StreamEntity')->findAll();

		// Set thumbnail size
		foreach($streamEntities as $game){
			$game->setBoxArtUrl(str_replace('{width}', $this->getVar('thumbGameWidth', '200'), $game->getBoxArtUrl()));
			$game->setBoxArtUrl(str_replace('{height}', $this->getVar('thumbGameHeight', '200'), $game->getBoxArtUrl()));
		}

		//Render Page
		return $this->render('@KratorStreamModule/Game/index.html.twig', [
            'games' => $streamEntities,
        ]);
    }

	/**
     * @Route("/show/{id}"),
	 *   requirements = {"id" = "\d+"},
	 *   methods = {"GET"}
     * @Template()
     */
    public function showAction(Request $request, StreamEntity $streamEntity, TwitchHelper $twitchHelper)
    {
		//Favorites languages
		$favLang = $this->getVar('favLang');
		$languages = explode(',', $favLang);

		//Get streams by language
		$max = 20;
		$limit = 20;
		foreach($languages as $language){
			$tStreams = $twitchHelper->getStreamsByGameId($streamEntity->getGameId(), $language, $limit);
			if (!empty($tStreams)){
				if (!isset($streams)){
					$streams = $tStreams;
				} else {
					$streams = array_merge($streams, $tStreams);		
				}
				if (count($streams) >= $max){
					break;
				}else{
					$limit = $max - count($streams);
				}
			}
		}
		
		//If the max of streams if not reached, search more without languages
		if (count($streams) < $max){ 
			$limit = ($max - count($streams)) + 1;
			$tStreams = $twitchHelper->getStreamsByGameId($streamEntity->getGameId(), null, $limit);
			$streams = array_merge($streams, $tStreams);
		}

		//Fill the sizes of thumbs
		foreach($streams as &$stream){
			$stream->thumbnail_url = str_replace('{width}', $this->getVar('thumbStreamWidth', '260'), $stream->thumbnail_url);
			$stream->thumbnail_url = str_replace('{height}', $this->getVar('thumbStreamHeight', '180'), $stream->thumbnail_url);
		}

		//Render Page
		return $this->render('@KratorStreamModule/Game/show.html.twig', [
            'streams' => $streams,
			'game' => $streamEntity->getName()
        ]);

	}

	/**
     * @Route("/{stream_id}"),
	 *   requirements = {"stream_id" = "[^/]+"},
	 *   methods = {"GET"}
     * @Template()
     */
    public function displayAction(Request $request, $stream_id)
    {
		//Render Page
		return $this->render('@KratorStreamModule/Game/display.html.twig', [
            'stream_id' => $stream_id,
        ]);
	}

}
