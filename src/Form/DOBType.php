<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DOBType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateOfBirth', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'help' => 'Must be in YYYY-MM-DD format',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Next'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_field_name' => '_csrf',
            'csrf_token_id' => 'dob',
        ]);
    }
}
