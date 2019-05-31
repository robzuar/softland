<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ClientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codAux', TextType::class,
                [
                    'label' => 'codaux',
                    'attr' => ['class' => 'form-control'],
                    'constraints' => [ new NotBlank(["message" => "El campo Nombre no puede estar vacio"])],
                    'required' => false,
                ]
            )
            ->add('noFAux', TextType::class,
                [
                    'label' => 'nofaux',
                    'attr' => ['class' => 'form-control'],
                    'constraints' => [ new NotBlank(["message" => "El campo Nombre no puede estar vacio"])],
                    'required' => false,
                ]
            )
            ->add('nomAux', TextType::class,
                [
                    'label' => 'nomaux',
                    'attr' => ['class' => 'form-control'],
                    'constraints' => [ new NotBlank(["message" => "El campo Nombre no puede estar vacio"])],
                    'required' => false,
                ]
            )
            ->add('rutAux', TextType::class,
                [
                    'label' => 'rutaux',
                    'attr' => ['class' => 'form-control'],
                    'constraints' => [ new NotBlank(["message" => "El campo Nombre no puede estar vacio"])],
                    'required' => false,
                ]
            )
            ->add('dirAux', TextType::class,
                [
                    'label' => 'diraux',
                    'attr' => ['class' => 'form-control'],
                    'constraints' => [ new NotBlank(["message" => "El campo Nombre no puede estar vacio"])],
                    'required' => false,
                ]
            )
            ->add('enabled')
            ->add('createdat',DateType::Class, [
                    'format'=>'dd/MM/yyyy',
                    'label' => 'createdat',
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'form-control input-inline datepicker',
                        'data-provide' => 'datepicker',

                    ],
                    'required' => true,
                    'translation_domain' => true,
                ]
            )
            ->add('createdBy', EntityType::class, array(
                'class' => 'AppBundle\Entity\Usuario',
                'choice_label' => 'firstName',
                'placeholder' => 'please_choose',
                'empty_data' => 'createdby',
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
            'data_class' => 'AppBundle\Entity\Client'
        ));
    }
}
