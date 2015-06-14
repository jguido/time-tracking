<?php

namespace dElt4\SynthesisBundle\Controller;

use dElt4\SynthesisBundle\Manager\ReportingManager;
use dElt4\TimeBundle\Entity\Event;
use dElt4\TimeBundle\Entity\ProjectHasUser;
use IntlDateFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ReportController extends Controller
{
    /**
     * @Route("/admin/report/form", name="path_report_form")
     */
    public function showFormAction(Request $request)
    {
        if ($this->isGranted('ROLE_ADMIN')) {

            $data = array();
            $form = $this->createFormBuilder($data)
                ->add('from', 'datetime', array('widget' => 'single_text', 'attr' => array('class' => 'datepicker')))
                ->add('to', 'datetime', array('widget' => 'single_text', 'attr' => array('class' => 'datepicker')))
                ->add('project', 'entity', array(
                    'class' => 'dElt4TimeBundle:Project',
                    'choices' => $this->get('doctrine.orm.default_entity_manager')->getRepository('dElt4TimeBundle:Project')->findAll()
                ))->getForm();

            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $results = $this->get('doctrine.orm.default_entity_manager')->getRepository('dElt4TimeBundle:Event')->findByProjectFromTo(
                    $data['project']->getId(),
                    $data['from'],
                    $data['to']
                );

                $reportManager = new ReportingManager();
                $reporting = $reportManager->renderReport($results, $data);

                $response = new Response($this->get('serializer')->serialize($reporting, 'json'), 200);
                $response->headers->add(array('Content-Type', 'application/json'));

                return $response;
            }

            return $this->render('dElt4SynthesisBundle:Default:index.html.twig', array(
                'admin' => null,
                'action' => null,
                'base_template' => '::standard_layout.html.twig',
                'admin_pool' => $this->get('sonata.admin.pool'),
                'form' => $form->createView()
            ));
        } else {
            return $this->redirect($this->generateUrl('sonata_admin_dashboard'));
        }
    }


}
