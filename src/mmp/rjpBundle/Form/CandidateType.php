<?php

namespace mmp\rjpBundle\Form;

use Doctrine\ORM\EntityRepository;
use mmp\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CandidateType extends AbstractType
{
    protected $userNew;
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $obj  = $this;

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
            ->add('user_new', new UserCandidateSimpleType, [
                'mapped' => false
            ])
            ->add('votes')
            ->add('user', 'entity', [
                'class'         => 'mmpUserBundle:User',
                'required'      => false,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.last_name', 'ASC');
            }])
            ->add('age')
            ->add('occupation')
            ->add('submit', 'submit')
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $candidate = $event->getData();
//                $form = $event->getForm();

                if($candidate['user_new'] && !$candidate['user']) {
                    $this->userNew = $candidate['user_new'];                
                } 
            })
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use ($obj) {
//                $candidate = $event->getData();
                $form = $event->getForm();

                if($this->userNew) {
                    $user = new User;
                    $user->setFirstName($this->userNew['first_name']);
                    $user->setLastName($this->userNew['last_name']);
                    $user->setUsername($this->userNew['first_name'] . ' ' . $this->userNew['last_name']);
                    $user->setEmail(uniqid() . '@omta.pl');
                    $user->setPassword('');
                    $form->getNormData()->setUser($user);
                }
            })
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
