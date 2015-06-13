<?php
/**
 * Created by PhpStorm.
 * User: dj3
 * Date: 13/06/15
 * Time: 19:10
 */

namespace dElt4\SynthesisBundle\Manager;


use dElt4\SynthesisBundle\Entity\Configuration;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class ConfigurationCheckManager implements AuthenticationSuccessHandlerInterface {

    /**
     * @var ObjectManager
     */
    private $_om;

    private $router;

    public function __construct(ObjectManager $_om, Router $router)
    {
        $this->_om = $_om;
        $this->router = $router;
    }

    /**
     * This is called when an interactive authentication attempt succeeds. This
     * is called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request $request
     * @param TokenInterface $token
     *
     * @return Response never null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $configuration = $this->_om->getRepository('dElt4SynthesisBundle:Configuration')->find(1);
        if (!$configuration) {
            $configuration = new Configuration();
            $this->_om->persist($configuration);
            $this->_om->flush($configuration);
        }

        return new RedirectResponse($this->router->generate('sonata_admin_dashboard'));
    }
}