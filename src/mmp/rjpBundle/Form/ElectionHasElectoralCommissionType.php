<?php

namespace mmp\rjpBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ElectionHasElectoralCommissionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('votes')
            ->add('authorized')
            ->add('election')
            ->add('district')
            // ->add('houseNumbersWithStreets')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mmp\rjpBundle\Entity\ElectionHasElectoralCommission',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mmp_rjpbundle_electionhaselectoralcommission';
    }
}
