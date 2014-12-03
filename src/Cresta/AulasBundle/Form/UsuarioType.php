<?php

namespace Cresta\AulasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Cresta\AulasBundle\Entity\Usuario;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\EventListener\TrimListener;


class UsuarioType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('persona')
            ->add('username','text',array('label'=>'Usuario: '))
            ->add('email','text',array('label'=>'Email: '))
            ->add('enabled','checkbox',array('label'=>'Activo:','required'=>false,'data'=>true))
            ->add('administrador', new AdministradorType(),array('label'=>' '));
            //->add('docente','choice', array('choices'=>array('a'=>'Administrador', 'd'=>'Docente'),'required'=>true))
/*            ->add('docente', 'checkbox',array('label'=>'Docente'))
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                    $select = $event->getData();
                    $form = $event->getForm();

                    if (true === $select['docente']) {
                        $builder->add('docente','entity',array('class'=>'CrestaAulasBundle:Docente','property'=>'nombre'));
                    } else {
                        $builder->add('administrador','entity',array('class'=>'CrestaAulasBundle:Administrador','property'=>'nombre'));
                    }
            })
            ->getForm();
*/
            //->add('docente','entity',array('class'=>'CrestaAulasBundle:Docente','property'=>'nombre'))
            //->add('administrador','entity',array('class'=>'CrestaAulasBundle:Administrador','property'=>'nombre'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cresta\AulasBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cresta_aulasbundle_usuario';
    }
}
