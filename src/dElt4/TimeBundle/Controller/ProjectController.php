<?php

namespace dElt4\TimeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProjectController extends Controller
{
    /**
     * @Route("/admin/app/projects", name="path_projects", options={"expose":true})
     */
    public function listAction()
    {
        $projects = $this->get('doctrine.orm.default_entity_manager')->getRepository('dElt4TimeBundle:Project')->findByUser($this->getUser());

        return new JsonResponse($projects, 200);
    }
}
