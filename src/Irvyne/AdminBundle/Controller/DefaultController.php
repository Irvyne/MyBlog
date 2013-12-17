<?php

namespace Irvyne\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('IrvyneAdminBundle:Default:index.html.twig', array('name' => $name));
    }
}
