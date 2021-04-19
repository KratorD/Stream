<?php
// @Template("KratorStreamModule:Admin:config.html.twig")
namespace Krator\StreamModule\Controller;

use Zikula\Bundle\CoreBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Zikula\ThemeModule\Engine\Annotation\Theme;

use Krator\StreamModule\Form\Type\ConfigType;
use Krator\StreamModule\AppSettings;
use Zikula\UsersModule\Api\CurrentUserApi;
use Psr\Log\LoggerInterface;

/**
* @Route("/config")
 */
class ConfigController extends AbstractController
{
    /**
     * @Route("/settings")
     * @Theme("admin")
     */
    public function settingsAction(Request $request, AppSettings $appSettings,CurrentUserApi $currentUserApi, LoggerInterface $logger)
    {
        // Check permissions
		if (!$this->hasPermission($this->name . '::', '::', ACCESS_ADMIN)) {
            throw new AccessDeniedException($this->trans('You do not have pemission to access the Stream admin interface.'));			
        }
		
		// Generate Form
		$form = $this->createForm(ConfigType::class, $appSettings);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('save')->isClicked()) {
				// Get values from form and save it
                $appSettings = $form->getData();
                $appSettings->save();
        
                $this->addFlash('status', $this->trans('Done! Module configuration updated.'));
                $userName = $currentUserApi->get('uname');
                $logger->notice('{app}: User {user} updated the configuration.', ['app' => 'KratorStreamModule', 'user' => $userName]);
            } elseif ($form->get('cancel')->isClicked()) {
                $this->addFlash('status', $this->trans('Operation cancelled.'));
            }
        
            // redirect to config page again (to show with GET request)
            return $this->redirectToRoute('kratorstreammodule_config_settings');
        }
        
		// Show form
        $templateParameters = [
            'form' => $form->createView()
        ];
        
        // render the config form
        return $this->render('@KratorStreamModule/Config/settings.html.twig', $templateParameters);
    }
}
