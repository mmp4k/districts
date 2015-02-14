<?php

namespace mmp\rjpBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ElectionHasElectoralCommissionStreetsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('election', 'entity', [
                'disabled'  => true,
                'read_only' => true,
                'class'     => 'mmp\rjpBundle\Entity\Election'
            ])
            ->add('district', 'entity', [
                'disabled'  => true,
                'read_only' => true,
                'class'     => 'mmp\rjpBundle\Entity\District'
            ])
            ->add('houseNumbersWithStreets', 'entity', [
                'multiple'      => true, 
                'expanded'      => true,
                'class'         => 'mmp\rjpBundle\Entity\HouseNumber',
                'data_class'    => null,
                'query_builder' => function(EntityRepository $er) use($builder){
                    return $er
                        ->createQueryBuilder('hn')
                        ->addSelect('hn.number+0 as HIDDEN int_number')
                        ->join('hn.district', 'd')->addSelect('d')
                        ->where('hn.district = :district')
                        ->orderBy('hn.street, int_number')
                        ->setParameters([
                            'district' => $builder->getData()->getDistrict()
                        ]);
                }                
            ])
            ->add('submit', 'submit');
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mmp\rjpBundle\Entity\ElectionHasElectoralCommission'
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
