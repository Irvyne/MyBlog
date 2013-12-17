<?php

namespace Irvyne\ZurbFoundationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('IrvyneZurbFoundationBundle:Default:index.html.twig', array('name' => $name));
    }
}
