<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\NotBlank;

class BillControlType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('receivedAt',DateType::Class, [
                    'label' => 'Fecha Recepción',
                    'widget' => 'single_text',
                    'attr' => [
                        'min' => (new \DateTime())->format('c'), 'max' => (new \DateTime())->format('c')
                    ],
                    'required' => true,
                    'translation_domain' => true,
                ]
            )
            ->add('typeComplaint',EntityType::class, [
                    'label' => 'Seleccione Motivo',
                    'query_builder' => function(\Doctrine\ORM\EntityRepository $repository){
                        return $repository->createQueryBuilder('p')
                            ->where('p.enabled = 1')
                            ->addOrderBy('p.name', 'ASC');
                    },
                    'placeholder'   => 'Seleccionar Motivo',
                    'class' => 'AppBundle:TypeComplaint',
                    'choice_label' => function($typeComplaint) {
                        /** @var TypeComplaint $vehicle */
                        return $typeComplaint->getName();
                    },
                    'multiple' => false,
                    'choices_as_values' => true,
                    'expanded' => false,
                    'required' => true,
                    'constraints' => [ new NotBlank()],
                ]
            )
            ->add('creditNote', IntegerType::class, ['label' => 'Nota de Credito','attr' => ['class' => 'form-control'], 'required' => true,'constraints' => [ new NotBlank(["message" => 'not_blank'])],])
            //->add('mount', IntegerType::class, ['label' => 'Monto Dev.','attr' => ['class' => 'form-control'], 'required' => true,'constraints' => [ new NotBlank(["message" => 'not_blank'])],])
            ->add('discount', IntegerType::class, ['label' => 'Cant. Devolución','attr' => ['class' => 'form-control'], 'required' => true,'constraints' => [ new NotBlank(["message" => 'not_blank'])],])
            ->add('mount', IntegerType::class, ['label' => 'Valor. Devolución','attr' => ['class' => 'form-control'], 'required' => true,'constraints' => [ new NotBlank(["message" => 'not_blank'])],])
            ->add('comment', TextType::class, ['label' => 'Comentario','attr' => ['class' => 'form-control'], 'required' => false,])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\BillControl'
        ));
    }
}
