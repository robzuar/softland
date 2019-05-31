<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nroInt')
            ->add('nvNumero')
            ->add('folio')
            ->add('fecha')
            ->add('glosa')
            ->add('codAux')
            ->add('codLugarDesp')
            ->add('nsValue')
            ->add('percentage')
            ->add('enabled')
            ->add('createdAt')
            ->add('status', EntityType::class, array(
                'class' => 'AppBundle\Entity\Status',
                'choice_label' => 'name',
                'placeholder' => 'Please choose',
                'empty_data' => null,
                'required' => false
 
            )) 
            ->add('client', EntityType::class, array(
                'class' => 'AppBundle\Entity\Client',
                'choice_label' => 'codAux',
                'placeholder' => 'Please choose',
                'empty_data' => null,
                'required' => false
 
            )) 
            ->add('dispatch', EntityType::class, array(
                'class' => 'AppBundle\Entity\Dispatch',
                'choice_label' => 'codAxd',
                'placeholder' => 'Please choose',
                'empty_data' => null,
                'required' => false
 
            )) 
            ->add('vehicle', EntityType::class, array(
                'class' => 'AppBundle\Entity\Vehicle',
                'choice_label' => 'patent',
                'placeholder' => 'Please choose',
                'empty_data' => null,
                'required' => false
 
            )) 
            ->add('createdBy', EntityType::class, array(
                'class' => 'AppBundle\Entity\Usuario',
                'choice_label' => 'firstName',
                'placeholder' => 'Please choose',
                'empty_data' => null,
                'required' => false
 
            )) 
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Bill'
        ));
    }
}
