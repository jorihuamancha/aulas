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
        $horaActual=new \DateTime();
        $horaActual->format('H:i:s');
        $builder
            ->add('usuario','entity',array( 'class'=>'CrestaAulasBundle:Usuario',
                                            'property'=>'username',
                                            'attr'=>array('class'=>'oculto'),
                                            'label'=>' '))
            //->add('usuario', 'text', array('attr'=>array('class'=>'oculto')))
            ->add('estado', 'checkbox', array(  'data'=>true, 'required'=>false,
                                                'attr'=>array('class'=>'oculto')))
            ->add('observaciones', 'text', array('required'=>false))
            ->add('docente','entity',array( 'class'=>'CrestaAulasBundle:Docente',
                                            'property'=>'apellido'.'nombre',
                                            'attr'=>array('required'=>true,
                                                          'class'=>"chzn-select" ) ) )
            ->add('curso','entity',array(   'class'=>'CrestaAulasBundle:Curso',
                                            'property'=>'cursocarrera',
                                            'attr'=>array('required'=>true,
                                                          'class'=>"chzn-select" )))
            
            ->add('actividad','entity',array(   'class'=>'CrestaAulasBundle:Actividad',
                                                'property'=>'nombre',
                                                'attr'=>array( 
                                                                'required'=>'true',
                                                                'class'=>"chzn-select", 
                                                                'style'=>"width:200px" ) ))
            ->add('fecha', 'datetime', array(   'data'=>$fechaActual,
                                                'attr'=>array('required'=>true )))//new \DateTime()->format('Y-m-d') ) ) //("now")
            ->add('horaDesde', 'datetime', array(   'data'=>$horaActual,
                                                    'hours'=>range(8,22), 
                                                    'minutes'=>array(   '00'=>'00',
                                                                        '30'=>'30'),
                                                    'attr'=>array('required'=>true) 
                    ) )//new \DateTime('H:i:s') ) )//, 'hours'=>range(8,22), 'minutes'=>array('00'=>'00', '30'=>'30') ) )
            ->add('horaHasta', 'datetime', array(   'data'=>$horaActual, 
                                                    'hours'=>range(8,22), 
                                                    'minutes'=>array(   '00'=>'00', 
                                                                        '30'=>'30' ),
                                                    'attr'=>array('required'=>true)
                                                ) 
                    )//new \DateTime("H:i:s") ) ) //, 'hours'=>range(8,22), 'minutes'=>array('00'=>'00', '30'=>'30') ) )
            ->add('recursos','entity',array('class'=>'CrestaAulasBundle:Recurso',
                                            'property'=>'nombre',
                                            'multiple'=>true,
                                            'expanded'=>true,
                                            'attr'=>array('required'=>true)))
            ->add('aula','entity',array('class'=>'CrestaAulasBundle:Aula',
                                        'property'=>'nombre'.'capacidad',
                                        'attr'=>array('required'=>true)))
            ->add('observaciones', 'text', array('required'=>false))
            ->add('fechaRegistro', 'datetime', array(   'data'=>$fechaActual, //new \DateTime("Y-m-d"),
                                                        'attr'=>array('class'=>'oculto'),
                                                        'label'=>' '))
            ->add('horaRegistro', 'datetime', array(    'data'=>$horaActual, //new \DateTime("H:i:s"),
                                                        'attr'=>array('class'=>'oculto'),
                                                        'label'=>' ') )
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
