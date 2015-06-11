<?php

namespace dElt4\TimeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    /**
     * @Route("/admin/app/events/{date}", name="path_events", options={"expose":true})
     */
    public function listAction($date)
    {
        $events = $this->get('doctrine.orm.default_entity_manager')->getRepository('dElt4TimeBundle:Event')->getEvents(\DateTime::createFromFormat('Y-m', $date), $this->getUser());

        $response = new Response($this->get('serializer')->serialize($events, 'json'), 201);
        $response->headers->add(array('Content-Type', 'application/json'));

        return $response;
    }
}
