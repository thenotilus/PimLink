<?php

namespace Notilus\PimLinkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PimLinkBundle:Default:index.html.twig', array('name' => $name));
    }
}
