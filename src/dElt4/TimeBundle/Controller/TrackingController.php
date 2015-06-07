<?php

namespace dElt4\TimeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TrackingController extends Controller
{
    /**
     * @Route("/admin/app/calendar", name="path_calendar")
     */
    public function indexAction()
    {
        return $this->render('dElt4TimeBundle:Default:index.html.twig', array(
            'admin' => null,
            'action' => null,
            'base_template' => '::standard_layout.html.twig',
            'admin_pool' => $this->get('sonata.admin.pool')
        ));
    }
}
