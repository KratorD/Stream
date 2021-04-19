<?php
/**
 * Stream.
 *
 * @copyright Krator (Krator)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Krator https://github.com/KratorD/.
 * @version Generated by ModuleStudio 1.4.0 (https://modulestudio.de).
 */

declare(strict_types=1);

namespace Krator\StreamModule;

use Symfony\Component\Validator\Constraints as Assert;
use Zikula\ExtensionsModule\Api\ApiInterface\VariableApiInterface;

/**
 * Application settings class for handling module variables.
 */
class AppSettings
{
    /**
     * @var VariableApiInterface
     */
    protected $variableApi;
	
	/**
     * Client ID from Twitch
     *
     * @Assert\Length(min="0", max="30")
     * @var string $clientId
     */
    protected $clientId = '';
	
	/**
     * Client Secret from Twitch
     *
     * @Assert\Length(min="0", max="30")
     * @var string $clientSecret
     */
    protected $clientSecret = '';
	
	/**
     * Thumbnail width game image.
     *
     * @Assert\Type(type="integer")
     * @Assert\NotBlank()
     * @Assert\NotEqualTo(value=0)
     * @Assert\LessThan(value=100000000000)
     * @var int $thumbGameWidth
     */
    protected $thumbBlockWidth = 80;
    
    /**
     * Thumbnail height game image.
     *
     * @Assert\Type(type="integer")
     * @Assert\NotBlank()
     * @Assert\NotEqualTo(value=0)
     * @Assert\LessThan(value=100000000000)
     * @var int $thumbGameHeight
     */
    protected $thumbBlockHeight = 80;
	
	/**
     * Thumbnail width stream image.
     *
     * @Assert\Type(type="integer")
     * @Assert\NotBlank()
     * @Assert\NotEqualTo(value=0)
     * @Assert\LessThan(value=100000000000)
     * @var int $thumbStreamWidth
     */
    protected $thumbStreamWidth = 260;
    
    /**
     * Thumbnail height stream image.
     *
     * @Assert\Type(type="integer")
     * @Assert\NotBlank()
     * @Assert\NotEqualTo(value=0)
     * @Assert\LessThan(value=100000000000)
     * @var int $thumbStreamHeight
     */
    protected $thumbStreamHeight = 180;
	
	/**
     * Thumbnail width stream image.
     *
     * @Assert\Type(type="integer")
     * @Assert\NotBlank()
     * @Assert\NotEqualTo(value=0)
     * @Assert\LessThan(value=100000000000)
     * @var int $streamWidth
     */
    protected $streamWidth = 1280;
    
    /**
     * Thumbnail height stream image.
     *
     * @Assert\Type(type="integer")
     * @Assert\NotBlank()
     * @Assert\NotEqualTo(value=0)
     * @Assert\LessThan(value=100000000000)
     * @var int $streamHeight
     */
    protected $streamHeight = 720;

	/**
     * Number of streams that could be showed in the block.
     *
     * @Assert\Type(type="integer")
     * @Assert\NotBlank()
     * @Assert\NotEqualTo(value=0)
     * @Assert\LessThan(value=100000000000)
     * @var int $streamHeight
     */
    protected $streamsBlock = 5;
	
	/**
     * Favorite Languages
     *
     * @Assert\Length(min="0", max="20")
     * @var string $favLang
     */
    protected $favLang = '';
	
	public function __construct(
        VariableApiInterface $variableApi
    ) {
        $this->variableApi = $variableApi;
    
        $this->load();
    }
	
	/**
     * Returns the ClientId.
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }
    
    /**
     * Sets the ClientId.
     *
     * @param string $clientId
     *
     * @return void
     */
    public function setClientId($clientId)
    {
        if ($this->clientId !== $clientId) {
            $this->clientId = isset($clientId) ? $clientId : '';
        }
    }
	
	/**
     * Returns the Secret Id.
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }
    
    /**
     * Sets the Secret Id.
     *
     * @param string $clientSecret
     *
     * @return void
     */
    public function setClientSecret($clientSecret)
    {
        if ($this->clientSecret !== $clientSecret) {
            $this->clientSecret = isset($clientSecret) ? $clientSecret : '';
        }
    }
	
	/**
     * Returns parameter.
     *
     * @return int
     */
    public function getThumbBlockWidth()
    {
        return $this->thumbBlockWidth;
    }
    
    /**
     * Sets parameter.
     *
     * @param int $thumbBlockWidth
     *
     * @return void
     */
    public function setThumbBlockWidth($thumbBlockWidth)
    {
        if ((int)$this->thumbBlockWidth !== (int)$thumbBlockWidth) {
            $this->thumbBlockWidth = (int)$thumbBlockWidth;
        }
    }
	
	/**
     * Returns parameter.
     *
     * @return int
     */
    public function getThumbBlockHeight()
    {
        return $this->thumbBlockHeight;
    }
    
    /**
     * Sets parameter.
     *
     * @param int $thumbBlockHeight
     *
     * @return void
     */
    public function setThumbBlockHeight($thumbBlockHeight)
    {
        if ((int)$this->thumbBlockHeight !== (int)$thumbBlockHeight) {
            $this->thumbBlockHeight = (int)$thumbBlockHeight;
        }
    }
	
	/**
     * Returns parameter.
     *
     * @return int
     */
    public function getThumbStreamWidth()
    {
        return $this->thumbStreamWidth;
    }
    
    /**
     * Sets parameter.
     *
     * @param int $thumbStreamWidth
     *
     * @return void
     */
    public function setThumbStreamWidth($thumbStreamWidth)
    {
        if ((int)$this->thumbStreamWidth !== (int)$thumbStreamWidth) {
            $this->thumbStreamWidth = (int)$thumbStreamWidth;
        }
    }
	
	/**
     * Returns parameter.
     *
     * @return int
     */
    public function getThumbStreamHeight()
    {
        return $this->thumbStreamHeight;
    }
    
    /**
     * Sets parameter.
     *
     * @param int $thumbStreamHeight
     *
     * @return void
     */
    public function setThumbStreamHeight($thumbStreamHeight)
    {
        if ((int)$this->thumbStreamHeight !== (int)$thumbStreamHeight) {
            $this->thumbStreamHeight = (int)$thumbStreamHeight;
        }
    }
	
	/**
     * Returns parameter.
     *
     * @return int
     */
    public function getStreamWidth()
    {
        return $this->streamWidth;
    }
    
    /**
     * Sets parameter.
     *
     * @param int $streamWidth
     *
     * @return void
     */
    public function setStreamWidth($streamWidth)
    {
        if ((int)$this->streamWidth !== (int)$streamWidth) {
            $this->streamWidth = (int)$streamWidth;
        }
    }
	
	/**
     * Returns parameter.
     *
     * @return int
     */
    public function getStreamHeight()
    {
        return $this->streamHeight;
    }
    
    /**
     * Sets parameter.
     *
     * @param int $streamHeight
     *
     * @return void
     */
    public function setStreamHeight($streamHeight)
    {
        if ((int)$this->streamHeight !== (int)$streamHeight) {
            $this->streamHeight = (int)$streamHeight;
        }
    }
	
	/**
     * Returns parameter.
     *
     * @return int
     */
    public function getStreamsBlock()
    {
        return $this->streamsBlock;
    }
    
    /**
     * Sets parameter.
     *
     * @param int $streamsBlock
     *
     * @return void
     */
    public function setStreamsBlock($streamsBlock)
    {
        if ((int)$this->streamsBlock !== (int)$streamsBlock) {
            $this->streamsBlock = (int)$streamsBlock;
        }
    }

	/**
     * Returns the Favorite languages.
     *
     * @return string
     */
    public function getFavLang()
    {
        return $this->favLang;
    }

    /**
     * Sets the Favorite languages.
     *
     * @param string $favLang
     *
     * @return void
     */
    public function setFavLang($favLang)
    {
        if ($this->favLang !== $favLang) {
            $this->favLang = isset($favLang) ? $favLang : '';
        }
    }

	/**
     * Loads module variables from the database.
     */
    protected function load(): void
    {
		$moduleVars = $this->variableApi->getAll('KratorStreamModule');

        if (isset($moduleVars['clientId'])) {
            $this->setClientId($moduleVars['clientId']);
        }
		if (isset($moduleVars['clientSecret'])) {
            $this->setClientSecret($moduleVars['clientSecret']);
        }
		if (isset($moduleVars['thumbBlockWidth'])) {
            $this->setThumbBlockWidth($moduleVars['thumbBlockWidth']);
        }
		if (isset($moduleVars['thumbBlockHeight'])) {
            $this->setThumbBlockHeight($moduleVars['thumbBlockHeight']);
        }
		if (isset($moduleVars['thumbStreamWidth'])) {
            $this->setThumbStreamWidth($moduleVars['thumbStreamWidth']);
        }
		if (isset($moduleVars['thumbStreamHeight'])) {
            $this->setThumbStreamHeight($moduleVars['thumbStreamHeight']);
        }
		if (isset($moduleVars['streamWidth'])) {
            $this->setStreamWidth($moduleVars['streamWidth']);
        }
		if (isset($moduleVars['streamHeight'])) {
            $this->setStreamHeight($moduleVars['streamHeight']);
        }
		if (isset($moduleVars['streamsBlock'])) {
            $this->setStreamsBlock($moduleVars['streamsBlock']);
        }
		if (isset($moduleVars['favLang'])) {
            $this->setFavLang($moduleVars['favLang']);
        }
	}
	
	/**
     * Saves module variables into the database.
     */
    public function save(): void
    {
        $this->variableApi->set('KratorStreamModule', 'clientId', $this->getClientId());
		$this->variableApi->set('KratorStreamModule', 'clientSecret', $this->getClientSecret());
		$this->variableApi->set('KratorStreamModule', 'thumbBlockWidth', $this->getThumbBlockWidth());
		$this->variableApi->set('KratorStreamModule', 'thumbBlockHeight', $this->getThumbBlockHeight());
		$this->variableApi->set('KratorStreamModule', 'thumbStreamWidth', $this->getThumbStreamWidth());
		$this->variableApi->set('KratorStreamModule', 'thumbStreamHeight', $this->getThumbStreamHeight());
		$this->variableApi->set('KratorStreamModule', 'streamWidth', $this->getStreamWidth());
		$this->variableApi->set('KratorStreamModule', 'streamHeight', $this->getStreamHeight());
		$this->variableApi->set('KratorStreamModule', 'streamsBlock', $this->getStreamsBlock());
		$this->variableApi->set('KratorStreamModule', 'favLang', $this->getFavLang());
	}
}