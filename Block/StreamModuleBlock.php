<?php

/*
 * This file is part of the Krator\StreamModule package.
 *
 * Copyright Krator.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Krator\StreamModule\Block;

use Zikula\BlocksModule\AbstractBlockHandler;
use Krator\StreamModule\Helper\TwitchHelper;
use Krator\StreamModule\Entity\StreamEntityRepository;
use Zikula\ExtensionsModule\Api\ApiInterface\VariableApiInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * This block show a link to the extension or
 */
class StreamModuleBlock extends AbstractBlockHandler
{
	/**
     * @var TwitchHelper
     */
    protected $twitchHelper;

	/**
     * @var streamEntityRepository
     */
	private $streamEntityRepository;

	/**
     * @var VariableApiInterface
     */
    private $variableApi;
	
	/**
     * @var RouterInterface
     */
    private $router;

    public function getType(): string
    {
        return 'Block Streams';
    }

    public function display(array $properties): string
    {
        // get customize variables
		$nElements = $this->variableApi->get('KratorStreamModule', 'streamsBlock');
		$favLang = $this->variableApi->get('KratorStreamModule', 'favLang');
		$streams = array();

		// Retrieve all games
        $streamEntities = $this->streamEntityRepository->findAll();
		
		$languages = explode(',', $favLang);

		// Search streams order by language
		while (count($streams) <= $nElements){
			foreach($languages as $language){
				foreach($streamEntities as $game){
					$streams_tmp = $this->twitchHelper->getStreamsByGameId($game->getGameId(), $language);
					if (!empty($streams_tmp)){
						$streams = array_merge($streams, $streams_tmp);
						if (count($streams) >= $nElements){
							break;
						}
					}
				}
			}
		}

		// Stick x elements
		if (!empty($streams)){
			array_splice($streams, $nElements);
		}

		//Show Twitch image with link when no streams was found
		$url = $this->router->generate('kratorstreammodule_game_index');

		//Fill the sizes of thumbs
		foreach($streams as &$stream){
			$stream->thumbnail_url = str_replace('{width}', $this->getVar('thumbGameWidth', '50'), $stream->thumbnail_url);
			$stream->thumbnail_url = str_replace('{height}', $this->getVar('thumbGameWidth', '50'), $stream->thumbnail_url);
		}
		//Render Page
		return $this->renderView('@KratorStreamModule/Block/blockStreams.html.twig', [
			'streams' => $streams,
			'url' => $url
		]);

    }

    public function getFormClassName(): string
    {
        return '';
    }

    public function getFormTemplate(): string
    {
        return '';
    }

    public function getFormOptions(): array
    {
        return [];
    }
	
	/**
     * @required
     */
    public function setStreamEntityRepository(StreamEntityRepository $streamEntityRepository): void
    {
        $this->streamEntityRepository = $streamEntityRepository;
    }
	
	/**
     * @required
     */
    public function setTwitchHelper(TwitchHelper $twitchHelper): void
    {
        $this->twitchHelper = $twitchHelper;
    }

	/**
     * @required
     */
    public function setVariableApi(VariableApiInterface $variableApi): void
    {
        $this->variableApi = $variableApi;
    }
	
	/**
     * @required
     */
    public function setRouter(RouterInterface $router): void
    {
        $this->router = $router;
    }
}
