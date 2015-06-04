<?php

namespace dElt4\TimeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TrackingController extends Controller
{
    /**
     * @Route("/app/example", name="homepage")
     */
    public function indexAction($name)
    {
        return $this->render('dElt4TimeBundle:Default:index.html.twig', array('name' => $name));
    }
}
