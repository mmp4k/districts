<?php

namespace mmp\rjpBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ElectoralCommissionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('point')
            ->add('polygon')
            ->add('point_name')
            ->add('point_street')
            ->add('elections', 'collection', [
                'type' => new ElectionHasElectoralCommissionType(),
            ])
            ->add('submit', 'submit')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mmp\rjpBundle\Entity\ElectoralCommission',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mmp_rjpbundle_electoralcommission';
    }
}
