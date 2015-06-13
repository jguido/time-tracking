<?php
/**
 * Created by PhpStorm.
 * User: dj3
 * Date: 04/06/15
 * Time: 09:11
 */

namespace dElt4\TimeBundle\Admin;


use dElt4\TimeBundle\Entity\Project;
use dElt4\TimeBundle\Entity\ProjectHasUser;
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
                'required' => false,
                'label'    => 'Documents',
                'class'    => 'ApplicationSonataMediaBundle:Media',
                'multiple' => true
            ))
            ->add('projectHasUsers', 'sonata_type_collection', array(
                    'cascade_validation' => true
                ), array(
                    'edit'              => 'inline',
                    'inline'            => 'table',
                    'sortable'          => 'position',
                    'link_parameters'   => array('context' => 'default'),
                    'admin_code'        => 'project_has_user.admin'
                )
            )
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

    public function postPersist($object)
    {
        $this->linkObject($object);
    }

    public function postUpdate($object)
    {

        $this->linkObject($object);
    }

    protected function linkObject(Project $object)
    {
        $_em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.default_entity_manager');
        foreach ($object->getProjectHasUsers() as $projectHasUser) {
            if ($projectHasUser instanceof ProjectHasUser) {
                $projectHasUser->setProject($object);
                $_em->persist($projectHasUser);
            }
        }
        $_em->flush();
    }
} 