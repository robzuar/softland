<?php

namespace AppBundle\Form;

use AppBundle\Entity\Dispatch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\NotBlank;

class RouteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $days = [
            'Lunes' => 'LU',
            'Martes'    => 'MA',
            'Miercoles' => 'MI',
            'Jueves'    => 'JU',
            'Viernes'   => 'VI',
            'Sabado'    => 'SA',
            'Domingo'   => 'DO'
        ];
        $builder
            ->add('dispatch',EntityType::class, [
                    'query_builder' => function(\Doctrine\ORM\EntityRepository $repository){
                        return $repository->createQueryBuilder('p')
                            ->addOrderBy('p.nomDch', 'ASC');
                    },
                    'label'   => 'Ceco',
                    'placeholder'   => 'Seleccionar Ceco',
                    'class' => 'AppBundle:Dispatch',
                    'choice_label' => 'nomDch',
                    'multiple' => false,
                    'choices_as_values' => true,
                    'expanded' => false,
                    'required' => false
                ]
            )
            ->add('region',EntityType::class, [
                    'query_builder' => function(\Doctrine\ORM\EntityRepository $repository){
                        return $repository->createQueryBuilder('p')
                            ->addOrderBy('p.name', 'ASC');
                    },
                    'label'   => 'Region',
                    'placeholder'   => 'Seleccionar Región',
                    'class' => 'AppBundle:Region',
                    'choice_label' => 'name',
                    'multiple' => false,
                    'choices_as_values' => true,
                    'expanded' => false,
                    'required' => false
                ]
            )
            ->add('day', ChoiceType::class, [
                    'label'   => 'Día',
                    'placeholder'   => 'Seleccionar Día',
                    'choices' => $days,
                    'multiple' => false,
                    'expanded' => false
                ]
            )
            ->add('number', IntegerType::class, ['label' => 'Valor', 'attr' => ['class' => 'form-control', 'min' => 0, 'max' =>100], 'required' => false,])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Route'
        ));
    }
}
