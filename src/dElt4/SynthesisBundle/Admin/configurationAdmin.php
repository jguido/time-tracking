<?php
/**
 * Created by PhpStorm.
 * User: dj3
 * Date: 13/06/15
 * Time: 18:59
 */

namespace dElt4\SynthesisBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class configurationAdmin extends Admin {

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('logo', 'sonata_media_type', array('label' => 'Logo','provider' => 'sonata.media.provider.image'))
            ->add('denomination', 'text', array('label' => 'Denomination'))
            ->add('address', 'text', array('label' => 'Address', 'required' => false))
            ->add('cp', 'text', array('label' => 'cp', 'required' => false))
            ->add('city', 'text', array('label' => 'city', 'required' => false))
            ->add('country', 'text', array('label' => 'country', 'required' => false))
            ->add('email', 'email', array('label' => 'email', 'required' => false))
            ->add('phone', 'email', array('label' => 'phone', 'required' => false))
            ->add('webSite', 'url', array('label' => 'webSite', 'required' => false))
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('list');
        $collection->remove('add');
        $collection->remove('delete');
    }
} 