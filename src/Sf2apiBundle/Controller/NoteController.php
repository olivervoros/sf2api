<?php

namespace Sf2apiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sf2apiBundle\Entity\Note;
use Sf2apiBundle\Form\NoteType;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Note controller.
 */
// TODO: routenotfoundexception to json
class NoteController extends FOSRestController implements ClassResourceInterface {

    /**
     * Lists all Note entities.
     * 
     * @ApiDoc(
     *  resource=true,
     *  description="List all Notes",
     * )
     *
     */
    public function cgetAction() {

	$em = $this->getDoctrine()->getManager();
	$notes = $em->getRepository('Sf2apiBundle:Note')->findAll();
	$view = $this->view($notes, 200)
	->setTemplate("Sf2apiBundle:Note:cget.html.twig")
        ->setTemplateVar('notes');
	return $this->handleView($view);
    }

    /**
     * Finds and displays a Note entity.
     * 
     * @ApiDoc(
     *  resource=true,
     *  description="Find and display a Note",
     * )
     *
     */
    public function getAction($noteId) {
	$em = $this->getDoctrine()->getManager();
	$note = $em->getRepository('Sf2apiBundle:Note')->findOneBy(array('id' => $noteId));
	if (!$note instanceof Note)
	{
	    throw new NotFoundHttpException('Note not found');
	}

	$view = $this->view($note, 200)
	->setTemplate("Sf2apiBundle:Note:get.html.twig")
        ->setTemplateVar('note');
	return $this->handleView($view);
    }

    /**
     * Creates a new Note entity.
     * 
     * @ApiDoc(
     *  resource=true,
     *  description="Create a new Note",
     * )
     *
     */
    public function postAction(Request $request) {

	$note = new Note();
	$form = $this->createForm(new NoteType, $note); 
	
	// TODO: it works, but this part could be done in a more symfony way... 
	// Check if we have a json body post
	$data = json_decode($request->getContent(), true);

	// Post the data to the form
	$form->submit($data);

	if ($form->isValid())
	{
	    $em = $this->getDoctrine()->getManager();
	    $em->persist($note);
	    $em->flush();

	    $view = $this->view($note, 200);
	    return $this->handleView($view);
	}

	$errors = $form->getErrorsAsString();
	throw new BadRequestHttpException($errors);
    }

    /**
     * Edit an existing Note entity.
     * 
     * @ApiDoc(
     *  resource=true,
     *  description="Edit an existing Note",
     * )
     *
     */
    public function putAction(Request $request, $noteId) {
	$em = $this->getDoctrine()->getManager();
	$note = $em->getRepository('Sf2apiBundle:Note')->findOneBy(array('id' => $noteId));
	if (!$note instanceof Note)
	{
	    throw new NotFoundHttpException('Note not found');
	}

	$editForm = $this->createForm(new NoteType, $note);
	
	// TODO: it works, but this part could be done in a more symfony way... 
	// Check if we have a json body post
	$data = json_decode($request->getContent(), true);

	// Post the data to the form
	$editForm->submit($data);

	if ($editForm->isValid())
	{
	    if (!empty($data['title']))
	    {
		$note->setTitle($data['title']);
	    }
		if (!empty($data['description']))
	    {
		$note->setDescription($data['description']);
	    }
	    $em->flush();

	    $view = $this->view($note, 200);
	    return $this->handleView($view);
	}
	$errors = $editForm->getErrorsAsString();
	throw new BadRequestHttpException($errors);
    }

    /**
     * Deletes a Note Entity
     * @Rest\View(statusCode=204)
     * @ApiDoc(
     *  resource=true,
     *  description="Delete a Note",
     * )
     */
    public function deleteAction($noteId) {

	$em = $this->getDoctrine()->getManager();
	$note = $em->getRepository('Sf2apiBundle:Note')->findOneBy(array('id' => $noteId));
	if (!$note instanceof Note)
	{
	    throw new NotFoundHttpException('Note not found');
	}
	$em->remove($note);
	$em->flush();
    }

}
