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
            ->add('usuario', 'text')//, array('data'=>$nombreUsuario = $this->container->get('security.context')->getToken()->getUser();))
            ->add('estado', 'checkbox', array('data'=>true, 'required'=>false))
            ->add('observaciones', 'text', array('required'=>false))
            ->add('docente','entity',array('class'=>'CrestaAulasBundle:Docente','property'=>'apellido'))
            ->add('curso','entity',array('class'=>'CrestaAulasBundle:Curso','property'=>'nombre'))
            ->add('actividad','entity',array('class'=>'CrestaAulasBundle:Actividad','property'=>'nombre'))
            ->add('fecha', 'datetime', array('data'=>new \DateTime("now")))//,array('attr'=>array('year'=>date('Y'))))
            //, array('year' => 2011, 'month' => 06, 'day' => 05))//, array('attr'=>array('day'=>date('d'))))//, array('compound'=>array('year'=>date('Y'), 'month'=>date('m'), 'day'=>date('d') ) ) )
            ->add('horaDesde', 'entity', array('class'=>'CrestaAulasBundle:Horas', 'property'=>'hora'))
            ->add('horaHasta', 'entity', array('class'=>'CrestaAulasBundle:Horas', 'property'=>'hora'))            
            //->add('recursos','entity',array('class'=>'CrestaAulasBundle:Recurso','property'=>'nombre'))
            ->add('recursos','entity',array('class'=>'CrestaAulasBundle:Recurso','property'=>'nombre','multiple'=>true,'expanded'=>true))
            //->add('activo','checkbox',array('label'=>'Activo:','required'=>false,'data'=>true))
            ->add('aula','entity',array('class'=>'CrestaAulasBundle:Aula','property'=>'nombre'))
            //->add('usuario', 'text', array('data'=>'usuario'))
            /*Known options are: "action", "attr", "auto_initialize", "block_name", "by_reference", "cascade_validation", 
            "compound", "constraints", "csrf_field_name", "csrf_message", "csrf_protection", "csrf_provider", "data", "data_class", 
            "disabled", "empty_data", "error_bubbling", "error_mapping", "extra_fields_message", "inherit_data", "intention", "invalid_message",
             "invalid_message_parameters", "label", "label_attr", "mapped", "max_length", "method", "pattern", "post_max_size_message", 
             "property_path", "read_only", "required", "translation_domain", "trim", "validation_groups", "virtual"*/
            //->add('usuario', 'entity', array('class'=>'CrestaAulasBundle:Usuario','property'=>'id'))
            //->add('reservaUsuario','entity',array('class'=>'CrestaAulasBundle:Usuario','property'=>'id'))
            /*->add('usuario','entity',array( 'class'=>'CrestaAulasBundle:Usuario',
                                            'property'=>'id',
                                            'attr'=>array('class'=>'oculto')))
            /*->add('fechaRegistro', 'text', array('data'=>date('Y-m-d')))
            ->add('horaRegistro', 'text', array('data'=>date('h:i:s')))*/
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
