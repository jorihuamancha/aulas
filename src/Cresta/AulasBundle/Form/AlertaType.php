<?php

namespace Cresta\AulasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlertaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $fechaActual=new \DateTime();
        $fechaActual->format('Y-m-d');
        $builder
            ->add('fecha', 'datetime', array('attr'=>array('required'=>true) ) )
            ->add('fecha', 'datetime', array(   'data'=>$fechaActual,
                                                'attr'=>array(  'require'=>true)))
            //'format'=>'dd MM yyyy','label'=>'Fecha: '))
            ->add('descripcion','text',array('label'=>'Descripción: '))
            ->add('observaciones','text',array('label'=>'Observaciones: ','required'=>false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cresta\AulasBundle\Entity\Alerta'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cresta_aulasbundle_alerta';
    }
}
