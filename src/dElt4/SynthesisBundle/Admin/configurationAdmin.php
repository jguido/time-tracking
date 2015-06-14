<?php
/**
 * Created by PhpStorm.
 * User: dj3
 * Date: 13/06/15
 * Time: 18:59
 */

namespace dElt4\SynthesisBundle\Admin;

use dElt4\SynthesisBundle\Form\Type\ImagePickerType;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class configurationAdmin extends Admin {

    public function getFormTheme()
    {

        return array_merge(parent::getFormTheme(),
            array(
                'dElt4SynthesisBundle:Admin:widget_media.html.twig'
            )
        );
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('logo', 'sonata_type_model_list', array(
                'label' => 'Logo',
                'class' => 'ApplicationSonataMediaBundle:Media',
            ))
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