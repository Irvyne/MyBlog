<?php

namespace Irvyne\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Irvyne\BlogBundle\Entity\Category;
use Irvyne\BlogBundle\Form\CategoryType;

/**
 * Category controller.
 *
 */
class CategoryController extends Controller
{
    /**
     * Lists all Category entities.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('IrvyneBlogBundle:Category')->findAll();

        return $this->render('IrvyneBlogBundle:Category:index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Creates a new Category entity.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $category = new Category();
        $form = $this->createCategoryForm($category);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirect($this->generateUrl('category_show', array('slug' => $category->getSlug())));
        }

        return $this->render('IrvyneBlogBundle:Category:new.html.twig', array(
            'category'  => $category,
            'form'      => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Category entity.
     *
     * @param Category $category
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createCategoryForm(Category $category)
    {
        $form = $this->createForm(new CategoryType(), $category, array(
            'action' => $this->generateUrl('category_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Category entity.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $category = new Category();
        $form   = $this->createCategoryForm($category);

        return $this->render('IrvyneBlogBundle:Category:new.html.twig', array(
            'entity' => $category,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Category entity.
     *
     * @param Category $category
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);

        return $this->render('IrvyneBlogBundle:Category:show.html.twig', array(
            'category'      => $category,
            'delete_form'   => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @param Category $category
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Category $category)
    {
        $editForm = $this->createEditCategoryForm($category);
        $deleteForm = $this->createDeleteForm($category);

        return $this->render('IrvyneBlogBundle:Category:edit.html.twig', array(
            'category'      => $category,
            'edit_form'     => $editForm->createView(),
            'delete_form'   => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Category entity.
     *
     * @param Category $category
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createEditCategoryForm(Category $category)
    {
        $form = $this->createForm(new CategoryType(), $category, array(
            'action' => $this->generateUrl('category_update', array('slug' => $category->getSlug())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Category entity.
     *
     * @param Request $request
     * @param Category $category
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);
        $editForm = $this->createEditCategoryForm($category);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl('category_edit', array('slug' => $category->getSlug())));
        }

        return $this->render('IrvyneBlogBundle:Category:edit.html.twig', array(
            'category'      => $category,
            'edit_form'     => $editForm->createView(),
            'delete_form'   => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Category entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $category = $em->getRepository('IrvyneBlogBundle:Category')->find($id);

            if (!$category) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            $em->remove($category);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('category'));
    }

    /**
     * Creates a form to delete a Category entity by id.
     *
     * @param Category $category
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('slug' => $category->getSlug())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
