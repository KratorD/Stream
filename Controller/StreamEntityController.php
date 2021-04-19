<?php

namespace Krator\StreamModule\Controller;

use Krator\StreamModule\Entity\StreamEntity;
use Krator\StreamModule\Helper\TwitchHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Zikula\Bundle\CoreBundle\Controller\AbstractController;
use Zikula\ThemeModule\Engine\Annotation\Theme;

/*** Forms ***/
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Streamentity controller.
 *
 * @Route("stream")
 */
class StreamEntityController extends AbstractController
{
	/**
     * Lists all streamEntity entities.
     *
     * @Route("/list", name="stream_index")
	 * @Theme("admin")
     * @Method("GET")
     */
    public function indexAction()
    {
        // Permission
		if (!$this->hasPermission($this->name . '::', '::', ACCESS_ADMIN)) {
            throw new AccessDeniedException($this->trans('You do not have pemission to access the Stream admin interface.'));
        }

		$em = $this->getDoctrine()->getManager();

        $streamEntities = $em->getRepository('KratorStreamModule:StreamEntity')->findAll();

        return $this->render('@KratorStreamModule/Stream/index.html.twig', array(
            'streamEntities' => $streamEntities,
        ));
    }

    /**
     * Creates a new streamEntity entity.
     *
     * @Route("/new", name="stream_new")
	 * @Theme("admin")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, TwitchHelper $twitchHelper)
    {
		if (!$this->hasPermission($this->name . '::', '::', ACCESS_ADMIN)) {
            throw new AccessDeniedException($this->trans('You do not have pemission to access the Stream admin interface.'));
        }
		// Generate form
        $form = $this->createSearchForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $founds = $twitchHelper->searchGame($form->get('search')->getData());
			if (count($founds) < 1){
				$this->addFlash('error', $this->trans('No game/s was found.'));
				return $this->redirectToRoute('kratorstreammodule_streamentity_new');
			}else{
				$em = $this->getDoctrine()->getManager();
				foreach($founds as $juego){
					$streamEntity = new Streamentity();				
					$streamEntity->setGameId($juego->id);
					$streamEntity->setName($juego->name);
					$streamEntity->setBoxArtUrl($juego->box_art_url);
					
					$em->persist($streamEntity);
				}
				$em->flush();
				$this->addFlash('success', $this->trans('Game added.'));

				return $this->redirectToRoute('kratorstreammodule_streamentity_show', array('id' => $streamEntity->getId()));

			}
        }

		// Show form
		return $this->render('@KratorStreamModule/Stream/search.html.twig', [
            'form' => $form->createView(),
        ]);

    }

	/**
     * Creates a new streamEntity entity.
	 * @Route("/create", name="stream_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
		if (!$this->hasPermission($this->name . '::', '::', ACCESS_ADMIN)) {
            throw new AccessDeniedException($this->trans('You do not have pemission to access the Stream admin interface.'));
        }

		$selected = $request->request->get('items', null);
		if (!empty($selected)){
			$em = $this->getDoctrine()->getManager();
			$streamEntity = new Streamentity();
			foreach($selected as $juego){
				$streamEntity->setGameId($juego['gameid']); //Notice: Undefined index: gameid ¿?
				$streamEntity->setName($juego['name']);
				$streamEntity->setBoxArtUrl($juego['boxarturl']);
				
				$em->persist($streamEntity);
			}			
            $em->flush();
			return $this->redirectToRoute('kratorstreammodule_streamentity_show', array('id' => $streamEntity->getId()));
		}
	}

    /**
     * Finds and displays a streamEntity entity.
     *
     * @Route("/{id}", name="stream_show")
     * @Method("GET")
     */
    public function showAction(StreamEntity $streamEntity)
    {
        $deleteForm = $this->createDeleteForm($streamEntity);

        return $this->render('@KratorStreamModule/Stream/show.html.twig', array(
            'streamEntity' => $streamEntity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing streamEntity entity.
     *
     * @Route("/{id}/edit", name="stream_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, StreamEntity $streamEntity)
    {
        if (!$this->hasPermission($this->name . '::', '::', ACCESS_ADMIN)) {
            throw new AccessDeniedException($this->trans('You do not have pemission to access the Stream admin interface.'));
        }

		$deleteForm = $this->createDeleteForm($streamEntity);
        $editForm = $this->createForm('Krator\StreamModule\Form\StreamEntityType', $streamEntity);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('kratorstreammodule_streamentity_edit', array('id' => $streamEntity->getId()));
        }

        return $this->render('@KratorStreamModule/Stream/edit.html.twig', array(
            'streamEntity' => $streamEntity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a streamEntity entity.
     *
     * @Route("/{id}", name="stream_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, StreamEntity $streamEntity)
    {
        if (!$this->hasPermission($this->name . '::', '::', ACCESS_ADMIN)) {
            throw new AccessDeniedException($this->trans('You do not have pemission to access the Stream admin interface.'));
        }

		$form = $this->createDeleteForm($streamEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($streamEntity);
            $em->flush();
        }

        return $this->redirectToRoute('kratorstreammodule_streamentity_index');
    }

    /**
     * Creates a form to delete a streamEntity entity.
     *
     * @param StreamEntity $streamEntity The streamEntity entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(StreamEntity $streamEntity)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('kratorstreammodule_streamentity_delete', array('id' => $streamEntity->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

	/**
     * Creates a form to delete a streamEntity entity.
     *
     * @param StreamEntity $streamEntity The streamEntity entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createSearchForm()
    {
        return $this->createFormBuilder()
            ->add('search', SearchType::class, ['label' => 'Game'])
            ->add('save', SubmitType::class, ['label' => 'Search'])
			->setAction($this->generateUrl('kratorstreammodule_streamentity_new'))
            //->setMethod('POST')
            ->getForm();
    }

}
