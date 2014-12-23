<?php

namespace mmp\rjpBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DistrictType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug')
            ->add('name')
            ->add('status', 'choice', array(
                    'choices'    =>  array(
                        'exists' => 'Istnieje', 
                        'collecting' => 'Trwa zbiórka podpisów',
                        'need_coordinator' => 'Szukamy koordynatora',
                        'elections' =>  'Wybory',
                        'in_office' => 'Podpisy złożone')
                ))
            ->add('signature_needed')
            ->add('signature_gained')
            ->add('file', 'file') //avatar
            ->add('link_facebook')
            ->add('link_poster')
            ->add('link_template')
            ->add('link_kml')
            ->add('facebook_box')
            ->add('rjp_name')
            ->add('rjp_street')
            ->add('coordinator')
            ->add('submit', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mmp\rjpBundle\Entity\District'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mmp_rjpbundle_district';
    }
}
