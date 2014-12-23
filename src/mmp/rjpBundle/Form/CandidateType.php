<?php

namespace mmp\rjpBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormInterface;

class CandidateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('is_councilor', 'checkbox', [
                'value'    => '1',
                'required' => false
            ])
            ->add('election')
            
            ->add('district', 'entity', array(
                'class'         => 'mmpRjpBundle:District',
                'data_class'    => null,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('d')->orderBy('d.slug', 'ASC');
                }
            ))
            ->add('user')
            ->add('votes')
            ->add('submit', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mmp\rjpBundle\Entity\Candidate'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mmp_rjpbundle_candidate';
    }
}
