<?php

namespace dElt4\SynthesisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('dElt4SynthesisBundle:Default:index.html.twig', array('name' => $name));
    }
}
