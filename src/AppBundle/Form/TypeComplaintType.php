<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TypeComplaintType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
                [
                    'label' => 'name',
                    'attr' => ['class' => 'form-control'],
                    'constraints' => [ new NotBlank(["message" => "El campo Nombre no puede estar vacio"])],
                    'required' => false,
                ]
            )
            ->add('description', TextAreaType::class,
                [
                    'label' => 'description',
                    'attr' => [
                        'class' => 'form-control',
                        'min'   => 3,
                        'max'   => 254
                    ],
                    'constraints' => [ new NotBlank(["message" => "El campo Nombre no puede estar vacio"])],
                    'required' => false,
                ]
            )
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\TypeComplaint'
        ));
    }
}
