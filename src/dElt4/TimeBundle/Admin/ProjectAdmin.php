<?php
/**
 * Created by PhpStorm.
 * User: dj3
 * Date: 04/06/15
 * Time: 09:11
 */

namespace dElt4\TimeBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ProjectAdmin extends Admin {

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text', array('label' => 'Title'))
            ->add('description', 'text', array('label' => 'Description'))
            ->add('price', 'money', array('label' => 'Description', 'precision' => 2))
            ->add('documents', 'sonata_type_model', array(
                'label'    => 'Documents',
                'class'    => 'ApplicationSonataMediaBundle:Media',
                'multiple' => true
            ))
            ->add('users', 'sonata_type_model', array(
                'label'    => 'Users',
                'class'    => 'ApplicationSonataUserBundle:User',
                'multiple' => true
            ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('price')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('price')
        ;
    }
} 