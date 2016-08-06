<?php

namespace mmp\rjpBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ConfirmType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('yes', SubmitType::class, [
                'label' => 'form.yes',
            ])
            ->add('no', SubmitType::class, [
                'label' => 'form.no',
            ])
        ;
    }
}
