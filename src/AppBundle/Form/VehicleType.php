<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VehicleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('patent', TextType::class,
                [
                    'label' => 'patent',
                    'attr' => ['class' => 'form-control'],
                    'constraints' => [ new NotBlank(["message" => "El campo Nombre no puede estar vacio"])],
                    'required' => false,
                ]
            )
            ->add('owner', EntityType::class, array(
                'label' => 'owner',
                'class' => 'AppBundle\Entity\Owner',
                'choice_label' => 'name',
                'placeholder' => 'please_choose',
                'empty_data' => null,
                'constraints' => [ new NotBlank(["message" => "El campo Nombre no puede estar vacio"])],
 
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Vehicle'
        ));
    }
}
