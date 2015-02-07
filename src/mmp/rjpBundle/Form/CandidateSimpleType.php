<?php

namespace mmp\rjpBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormInterface;

class CandidateSimpleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', 'entity', [
                'disabled'  => true,
                'read_only' => true,
                'class'     => 'mmp\rjpBundle\Entity\User'
            ])
            ->add('votes')
            ->add('sex', 'choice', [
                'expanded' => true,
                'choices'  => [
                    ''  =>  '---',
                    'm' =>  'Male',
                    'f' =>  'Female'
                ]
            ])
            ->add('occupation')
            ->add('age')
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
