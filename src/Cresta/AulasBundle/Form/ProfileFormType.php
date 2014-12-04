<?php

namespace Cresta\AulasBundle\Form;

use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('administrador', new AdministradorType(),array('label'=>' '));
    }

    public function getName()
    {
        return 'cresta_aulasbundle_user_profile';
    }
}