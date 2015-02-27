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
            ->add('anio','text',array('label'=>'Año de la carrera:', 'pattern'=>"[0-9]+"))
            ->add('semestre', 'choice', array('label'=>'Semestre:',
                                              'choices'=> array(1 => 'Primer semestre',
                                                                2 => 'Segundo semestre'),
                                              'required'  => true))

            ->add('ciclo','text',array('label'=>'Ciclo lectivo:'))
            ->add('Carrera','entity',array('class'=>'CrestaAulasBundle:Carrera',
                                            'property'=>'nombre','label'=>'Carrera:',
                                            'attr'=>array('required'=>true,
                                                          'class'=>"chzn-select" )))
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
