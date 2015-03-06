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
        $fechaActual=new \DateTime();
        $fechaActual->format('Y-m-d');
        $anio=$fechaActual->format('Y');
        $mes=$anio=$fechaActual->format('m');
        $dia=$fechaActual->format('d');
        $horaActual=new \DateTime();
        $horaActual->format('H:i:s');
        $builder
            ->add('usuario','entity',array( 'class'=>'CrestaAulasBundle:Usuario',
                                            'property'=>'username',
                                            'attr'=>array('class'=>'oculto'),
                                            'label'=>' '))
            /*->add('estado', 'checkbox', array(  'data'=>true, 'required'=>false,
                                                'attr'=>array('class'=>'oculto')))*/
            ->add('curso','entity',array(   'label'=>'Materia: ',
                                            'class'=>'CrestaAulasBundle:Curso',
                                            'property'=>'cursocarrera',
                                            'attr'=>array('required'=>true,
                                                          'class'=>"chzn-select")))
            ->add('actividad','entity',array(   'label'=>'Actividad: ',
                                                'class'=>'CrestaAulasBundle:Actividad',
                                                'property'=>'nombre',
                                                'attr'=>array( 'required'=>'true','class'=>"chzn-select") ))
            ->add('docente','entity',array( 'label'=>'Docente: ',
                                            'class'=>'CrestaAulasBundle:Docente',
                                            'property'=>'apellido'.'nombre',
                                            'attr'=>array('required'=>true,
                                                          'class'=>"chzn-select",
                                                          'style'=>'min-width:150px' ) ) )
            ->add('rango', 'choice', array( 'label'=>'Frecuencia: ','choices'=>array(   0=>'Reserva única',
                                                                                        1=>'Cada un día',
                                                                                        7=>'Cada Una Semana',
                                                                                        14=>'Cada Dos Semanas')))
            ->add('fecha', 'datetime', array(   'label'=>'Fecha desde: ','attr'=>array(  'required'=>true)))
            ->add('rangoHasta', 'datetime', array( 'label'=>'Fecha Hasta: ','attr'=>array('required'=>true)))
            ->add('horaDesde', 'datetime', array(   'label'=>'Hora desde: ',
                                                    'hours'=>range(8,22), 
                                                    'minutes'=>array(   '00'=>'00',
                                                                        '30'=>'30'),
                                                    'attr'=>array('required'=>true)))
            ->add('horaHasta', 'datetime', array(   'label'=>'Hora hasta: ' ,
                                                    'hours'=>range(8,22), 
                                                    'minutes'=>array(   '00'=>'00', 
                                                                        '30'=>'30' ),
                                                    'attr'=>array('required'=>true)))            
            ->add('recursos','entity',array( 'label'=>'Recursos: ',
                                            'class'=>'CrestaAulasBundle:Recurso',
                                            'property'=>'nombre',
                                            'multiple'=>true,
                                            'expanded'=>true,
                                            'attr'=>array('required'=>true)))
            ->add('aula','entity',array('class'=>'CrestaAulasBundle:Aula',
                                        'property'=>'nombre'.'capacidad',
                                        'attr'=>array('required'=>true)))
            ->add('observaciones', 'text', array('label'=>'Observaciones: ',
                                                 'required'=>false))
            ->add('fechaRegistro', 'datetime', array(   'data'=>$fechaActual, //new \DateTime("Y-m-d"),
                                                        'attr'=>array('class'=>'oculto'),
                                                        'label'=>' '))
            ->add('horaRegistro', 'datetime', array(    'data'=>$horaActual, //new \DateTime("H:i:s"),
                                                        'attr'=>array('class'=>'oculto'),
                                                        'label'=>' ') )
            //->add('usuario', 'text', array('attr'=>array('class'=>'oculto')))
            //->add('rangoDesde', 'datetime', array( 'label'=>'Reservar Desde: ','attr'=>array('required'=>true)))
            //->add('rangoHasta', 'datetime', array( 'label'=>'Fecha Hasta: ','attr'=>array('required'=>true)))
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
