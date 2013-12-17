<?php

namespace Irvyne\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Irvyne\BlogBundle\Entity\Article;
use Irvyne\BlogBundle\Form\ArticleType;

/**
 * Article controller.
 *
 */
class ArticleController extends Controller
{

    /**
     * Lists all Article entities.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('IrvyneBlogBundle:Article')->findAll();

        return $this->render('IrvyneBlogBundle:Article:index.html.twig', array(
            'articles' => $articles,
        ));
    }

    /**
     * Finds and displays a Article entity.
     *
     * @param Article $article
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);

        return $this->render('IrvyneBlogBundle:Article:show.html.twig', array(
            'article'     => $article,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Article entity.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $article = new Article();
        $form   = $this->createArticleForm($article);

        return $this->render('IrvyneBlogBundle:Article:new.html.twig', array(
            'entity' => $article,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Article entity.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $article = new Article();
        $form = $this->createArticleForm($article);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('article_show', array('slug' => $article->getSlug())));
        }

        return $this->render('IrvyneBlogBundle:Article:new.html.twig', array(
            'article'   => $article,
            'form'      => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Article entity.
     *
     * @param Article $article
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Article $article)
    {
        $editForm = $this->createEditArticleForm($article);
        $deleteForm = $this->createDeleteForm($article);

        return $this->render('IrvyneBlogBundle:Article:edit.html.twig', array(
            'article'     => $article,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Article entity.
     *
     * @param Request $request
     * @param Article $article
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->createEditArticleForm($article);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl('article_edit', array('slug' => $article->getSlug())));
        }

        return $this->render('IrvyneBlogBundle:Article:edit.html.twig', array(
            'article'     => $article,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Article entity.
     *
     * @param Request $request
     * @param Article $article
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Article $article)
    {
        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('article'));
    }

    /**
     * Creates a form to create a Article entity.
     *
     * @param Article $article
     * @return \Symfony\Component\Form\Form
     */
    private function createArticleForm(Article $article)
    {
        $form = $this->createForm(new ArticleType(), $article, array(
            'action' => $this->generateUrl('article_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to edit a Article entity.
     *
     * @param Article $article
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createEditArticleForm(Article $article)
    {
        $form = $this->createForm(new ArticleType(), $article, array(
            'action' => $this->generateUrl('article_update', array('slug' => $article->getSlug())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Creates a form to delete a Article entity by id.
     *
     * @param Article $article
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('article_delete', array('slug' => $article->getSlug())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
