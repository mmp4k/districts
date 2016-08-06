<?php

namespace mmp\rjpBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserCandidateSimpleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('last_name')
            ->add('first_name')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mmp\UserBundle\Entity\User',
            'validation_groups' => function (FormInterface $form) {
                $data = $form->getData();
                $arToReturn = array();
                if (($data->getEmail() || $data->getUsername()) && !$data->getId()) {
                    $arToReturn[] = 'normal_user';
                } else {
                    $arToReturn[] = 'if_councilor';
                }

                return $arToReturn;
            },
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mmp_rjpbundle_user';
    }
}
