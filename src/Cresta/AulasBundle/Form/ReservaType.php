<?php

namespace Cresta\AulasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReservaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('usuario', 'text', array('attr'=>array('class'=>'oculto')))
            ->add('estado', 'checkbox', array('data'=>true, 'required'=>false))
            ->add('observaciones', 'text', array('required'=>false))
            ->add('docente','entity',array( 'class'=>'CrestaAulasBundle:Docente',
                                            'property'=>'apellido'))
            ->add('curso','entity',array(   'class'=>'CrestaAulasBundle:Curso',
                                            'property'=>'nombre'))
            ->add('actividad','entity',array(   'class'=>'CrestaAulasBundle:Actividad',
                                                'property'=>'nombre',
                                                'attr'=>array('disabled'=>'true')))
            ->add('fecha', 'datetime', array(   'data'=>new \Datetime ) )
            ->add('horaDesde', 'datetime', array(  'data'=>new \Datetime, 'hours'=>range(8,22), 'minutes'=>array('00'=>'00', '30'=>'30') ) )
            ->add('horaHasta', 'datetime', array(  'data'=>new \Datetime, 'hours'=>range(8,22), 'minutes'=>array('00'=>'00', '30'=>'30') ) )
            ->add('recursos','entity',array('class'=>'CrestaAulasBundle:Recurso',
                                            'property'=>'nombre',
                                            'multiple'=>true,
                                            'expanded'=>true))
            ->add('aula','entity',array('class'=>'CrestaAulasBundle:Aula',
                                        'property'=>'nombre'))
            ->add('fechaRegistro', 'datetime', array(   'data'=>new \DateTime("now"),
                                                        'attr'=>array('class'=>'oculto') ) )
            ->add('horaRegistro', 'datetime', array(    'data'=>new \DateTime("now"),
                                                        'attr'=>array('class'=>'oculto') ) )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cresta\AulasBundle\Entity\Reserva'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cresta_aulasbundle_reserva';
    }
}
