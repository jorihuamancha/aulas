<?php

namespace Cresta\AulasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AulaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre','text',array('label'=>'Nombre:')) //form-control
            ->add('piso','text',array('label'=>'Piso:'))
            ->add('recursosFijos', 'text', array('label'=>'Recursos fijos:'))
            ->add('capacidad','text',array('label'=>'Capacidad:','pattern'=>"[0-9]+"))
            ->add('observaciones', 'text', array('label'=>'Observaciones:','required'=>false))
            ->add('activo', 'checkbox',array('label'=>' ','data'=>true, 'attr'=>array('class'=>'oculto')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cresta\AulasBundle\Entity\Aula'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cresta_aulasbundle_aula';
    }
}
