<?php

namespace Cresta\AulasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocenteType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre','text',array('label'=>'Nombre: ',
                                        'pattern'=>"[a-zA-ZÑñá-úÁ-Ú ]+"))

            ->add('apellido','text',array('label'=>'Apellido: ',
                                        'pattern'=>"[a-zA-ZÑñá-úÁ-Ú ]+"))

            ->add('telefono','text',array('label'=>'Teléfono: ',
                                        'pattern'=>"[0-9()- ]+",
                                        'required'=>false))

            ->add('email','text',array('label'=>'Email: ',
                                        'pattern'=>"[a-zA-Z0-9@.- ]+",
                                        'required'=>false))
            ->add('observaciones','text',array('label'=>'Observaciones: ',
                                        'required'=>false))
           
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cresta\AulasBundle\Entity\Docente'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cresta_aulasbundle_docente';
    }
}
