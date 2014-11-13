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
            ->add('estado')
            ->add('observaciones')
            ->add('fechaRegistro')
            ->add('horaDesde')
            ->add('horaHasta')
            ->add('fechaReserva')
            ->add('cursos','entity',array('class'=>'CrestaAulasBundle:Curso','property'=>'nombre'))
            ->add('actividades','entity',array('class'=>'CrestaAulasBundle:Actividad','property'=>'nombre'))
            ->add('recursos','entity',array('class'=>'CrestaAulasBundle:Recurso','property'=>'nombre'))
            ->add('reservaPersona','entity',array('class'=>'CrestaAulasBundle:Persona','property'=>'nombre'))
            ->add('reservaAula','entity',array('class'=>'CrestaAulasBundle:Aula','property'=>'nombre'))
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
