<?php

namespace mmp\MeetingBundle\Form;

use Doctrine\ORM\EntityRepository;
use mmp\MeetingBundle\Entity\Meeting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MeetingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('district', 'entity', array( 
                    'class' => 'mmpRjpBundle:District',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('d')
                            ->orderBy('d.slug', 'ASC');
                    },
                ))
            ->add('date')
            ->add('place')
            ->add('map_coords')
            ->add('link_facebook')
            ->add('organizer')
            ->add('submit', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Meeting::class,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mmp_rjpbundle_meeting';
    }
}
