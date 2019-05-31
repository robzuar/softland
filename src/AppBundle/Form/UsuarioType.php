<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class  UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $roles = [
            'ROL Usuario'           => 'ROLE_USER',
            'Rol Administrador'     => 'ROLE_ADMIN',
            'Rol Super Admin'       => 'ROLE_SUPER_ADMIN',
        ];
        $builder
            ->add('email',
                EmailType::class,
                [
                    'label' => 'email',
                    'translation_domain' => 'FOSUserBundle',
                    'constraints' =>
                        [
                            new NotBlank
                            (
                                [
                                    "message" => "El campo Email no puede estar vacio"
                                ]
                            )
                            ,
                            new Email
                            (
                                [
                                    "message" => "Favor de ingresar un Email valido"
                                ]
                            ),
                        ]
                ]
            )
            ->add('firstName',
                TextType::class,
                [
                    'label' => 'firstName',
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ],
                    'constraints' =>
                        [
                            new NotBlank
                            (
                                [
                                    "message" => "El campo Nombres no puede estar vacio"
                                ]
                            )
                        ]
                ]
            )
            ->add('lastName',
                TextType::class,
                [
                    'label' => 'lastName',
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ],
                    'constraints' =>
                        [
                            new NotBlank
                            (
                                [
                                    "message" => "El campo Apellidos no puede estar vacio"
                                ]
                            )
                        ]
                ]
            )
            ->add('roles',
                ChoiceType::class,
                [
                    'label'   => 'Roles',
                    'choices' => $roles,
                    'multiple' => true,
                    'expanded' => false
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
            'data_class' => 'AppBundle\Entity\Usuario'
        ));
    }
}
