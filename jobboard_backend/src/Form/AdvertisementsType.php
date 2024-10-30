<?php

namespace App\Form;

use App\Entity\Advertisements;
use App\Entity\Companies;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertisementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('created_at', null, [
                'widget' => 'single_text',
            ])
            ->add('salary_min')
            ->add('experience_level')
            ->add('education_level')
            ->add('working_time')
            ->add('content')
            ->add('company')
            ->add('users', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Advertisements::class,
        ]);
    }
}
