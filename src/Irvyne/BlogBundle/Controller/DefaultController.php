<?php

namespace Irvyne\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IrvyneBlogBundle:Default:index.html.twig', array('name' => 'Irvyne'));
    }
}
