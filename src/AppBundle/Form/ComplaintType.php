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

class ComplaintType extends AbstractType
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
                    'attr' => [ 'min' => (new \DateTime())->format('c'), 'max' => (new \DateTime())->format('c')
                    ]
                ]
            )
            ->add('creditNote', IntegerType::class, ['label' => 'Nota de Credito','attr' => ['class' => 'form-control'], 'required' => false,])
            //->add('mount', IntegerType::class, ['label' => 'MONTO', 'attr' => ['class' => 'form-control'], 'required' => false,])
            ->add('discount', IntegerType::class, ['label' => 'Cantidad','attr' => ['class' => 'form-control'], 'required' => false,])
            ->add('typeComplaint',EntityType::class, [
                    'label' => 'TIPO DE RECLAMO',
                    'placeholder'   => 'Seleccionar Tipo de Reclamo',
                    'class' => 'AppBundle:TypeComplaint',
                    'choice_label' => 'name',
                    'multiple' => false,
                    'choices_as_values' => true,
                    'expanded' => false,
                    'required' => false
                ]
            )
            ->add('comment', TextType::class, ['label' => 'COMENTARIOS', 'attr' => ['class' => 'form-control'], 'required' => false,])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Complaint'
        ));
    }
}
