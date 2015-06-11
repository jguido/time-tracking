<?php

namespace dElt4\TimeBundle\Controller;

use dElt4\TimeBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @param Request $request
     * @Route("/admin/app/tracking", name="path_persist_tracking", methods={"POST"}, options={"expose":true})
     */
    public function _ajaxPesistTrackingAction(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $result = array();

            $_em = $this->get('doctrine.orm.default_entity_manager');
            $dateMonth = $request->request->has('month') ? $request->get('month') : null;
            $days = $request->request->has('days') ? $request->get('days') : null;
            if (is_array($days) && count($days) > 0) {
                foreach ($days as $day) {
                    if (isset($day['am']) && '' !== $day['am']) {
                        $result[] = $_em->getRepository('dElt4TimeBundle:Event')->findOrCreate($day['am'], $this->getUser(), 'am');
                    }
                    if (isset($day['pm']) && '' !== $day['pm']) {
                        $result[] = $_em->getRepository('dElt4TimeBundle:Event')->findOrCreate($day['pm'], $this->getUser(), 'pm');
                    }
                }

                $response = new Response($this->get('serializer')->serialize($result, 'json'), 201);
                $response->headers->add(array('Content-Type', 'application/json'));

                return $response;
            }
        } else {
            return new JsonResponse(null, 401, array('private ' => true));
        }
    }
}
