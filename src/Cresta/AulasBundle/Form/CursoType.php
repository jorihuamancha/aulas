<?php

namespace Cresta\AulasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CursoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre','text',array('label'=>'Nombre:'))
            ->add('anio','choice',array('label'=>'Año de la carrera:',
                                              'choices'=> array(1 => 'Primer año',
                                                                2 => 'Segundo año',
                                                                3 => 'Tercer año',
                                                                4 => 'Cuarto año',
                                                                5 => 'Quinto año',
                                                                6 => 'Sexto año',
                                                                7 => 'Séptimo año'),
                                              'required'  => true))
            ->add('semestre', 'choice', array('label'=>'Semestre:',
                                              'choices'=> array(1 => 'Primer semestre',
                                                                2 => 'Segundo semestre',
                                                                3 => 'Ambos',
                                                                4 => 'Anual'),
                                              'required'  => true))

            ->add('ciclo','text',array('label'=>'Ciclo lectivo:'))
            ->add('carrera','entity',array( 'class'=>'CrestaAulasBundle:Carrera',
                                            'property'=>'nombre',
                                            'label'=>'Carrera:',
                                            'attr'=>array('required'=>true,
                                                          'style'=>'min-width:100px',
                                                          'class'=>"chzn-select" )))
            ->add('observaciones','text',array('label'=>'Observaciones:', 'required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cresta\AulasBundle\Entity\Curso'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cresta_aulasbundle_curso';
    }
}
