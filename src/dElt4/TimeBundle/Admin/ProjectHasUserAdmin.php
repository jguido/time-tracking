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

class ProjectHasUserAdmin extends Admin {

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper

            ->add('user', 'sonata_type_model', array(
                'label'    => 'User',
                'class'    => 'ApplicationSonataUserBundle:User'
            ))
            ->add('costPerDay', 'money', array(
                'label' => 'costPerDay'
            ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('user')
            ->add('costPerDay')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('user')
            ->add('costPerDay')
        ;
    }
} 