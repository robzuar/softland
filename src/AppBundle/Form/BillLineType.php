<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillLineType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nroInt')
            ->add('codProd')
            ->add('codAux')
            ->add('fecha')
            ->add('linea')
            ->add('detProd')
            ->add('codeUMed')
            ->add('cantFacturada')
            ->add('preUniMB')
            ->add('cantFactUVta')
            ->add('totLinea')
            ->add('enabled')
            ->add('nsValueControl')
            ->add('percentageControl')
            ->add('nsValueComplaint')
            ->add('percentageComplaint')
            ->add('createdAt')
            ->add('status', EntityType::class, array(
                'class' => 'AppBundle\Entity\Status',
                'choice_label' => 'name',
                'placeholder' => 'Please choose',
                'empty_data' => null,
                'required' => false
 
            )) 
            ->add('bill', EntityType::class, array(
                'class' => 'AppBundle\Entity\Bill',
                'choice_label' => 'glosa',
                'placeholder' => 'Please choose',
                'empty_data' => null,
                'required' => false
 
            )) 
            ->add('product', EntityType::class, array(
                'class' => 'AppBundle\Entity\Product',
                'choice_label' => 'codProd',
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
            'data_class' => 'AppBundle\Entity\BillLine'
        ));
    }
}
