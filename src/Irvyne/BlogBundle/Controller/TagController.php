<?php

namespace Irvyne\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Irvyne\BlogBundle\Entity\Tag;
use Irvyne\BlogBundle\Form\TagType;

/**
 * Tag controller.
 *
 */
class TagController extends Controller
{
    /**
     * Lists all Tag entities.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tags = $em->getRepository('IrvyneBlogBundle:Tag')->findAll();

        return $this->render('IrvyneBlogBundle:Tag:index.html.twig', array(
            'tags' => $tags,
        ));
    }

    /**
     * Finds and displays a Tag entity.
     *
     * @param Tag $tag
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Tag $tag)
    {
        $deleteForm = $this->createDeleteForm($tag);

        return $this->render('IrvyneBlogBundle:Tag:show.html.twig', array(
            'tag'           => $tag,
            'delete_form'   => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Tag entity.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $tag = new Tag();
        $form = $this->createTagForm($tag);

        return $this->render('IrvyneBlogBundle:Tag:new.html.twig', array(
            'tag'   => $tag,
            'form'  => $form->createView(),
        ));
    }

    /**
     * Creates a new Tag entity.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $tag = new Tag();
        $form = $this->createTagForm($tag);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();

            return $this->redirect($this->generateUrl('tag_show', array('slug' => $tag->getSlug())));
        }

        return $this->render('IrvyneBlogBundle:Tag:new.html.twig', array(
            'tag'   => $tag,
            'form'  => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tag entity.
     *
     * @param Tag $tag
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Tag $tag)
    {
        $editForm = $this->createEditTagForm($tag);
        $deleteForm = $this->createDeleteForm($tag);

        return $this->render('IrvyneBlogBundle:Tag:edit.html.twig', array(
            'tag'           => $tag,
            'edit_form'     => $editForm->createView(),
            'delete_form'   => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Tag entity.
     *
     * @param Request $request
     * @param Tag $tag
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, Tag $tag)
    {
        $deleteForm = $this->createDeleteForm($tag);
        $editForm = $this->createEditTagForm($tag);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl('tag_edit', array('slug' => $tag->getSlug())));
        }

        return $this->render('IrvyneBlogBundle:Tag:edit.html.twig', array(
            'tag'           => $tag,
            'edit_form'     => $editForm->createView(),
            'delete_form'   => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tag entity.
     *
     * @param Request $request
     * @param Tag $tag
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Tag $tag)
    {
        $form = $this->createDeleteForm($tag);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tag);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tag'));
    }

    /**
     * Creates a form to create a Tag entity.
     *
     * @param Tag $tag
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createTagForm(Tag $tag)
    {
        $form = $this->createForm(new TagType(), $tag, array(
            'action' => $this->generateUrl('tag_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to edit a Tag entity.
     *
     * @param Tag $tag
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createEditTagForm(Tag $tag)
    {
        $form = $this->createForm(new TagType(), $tag, array(
            'action' => $this->generateUrl('tag_update', array('slug' => $tag->getSlug())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Creates a form to delete a Tag entity by id.
     *
     * @param Tag $tag
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Tag $tag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tag_delete', array('slug' => $tag->getSlug())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
