<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class COPPAType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('parentGuardianEmail', EmailType::class, [
                'label' => "Parent or Guardian's Email",
                'help' => "Children under the age of 13 must have their parent or guardian's permission to use this service.",
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_field_name' => '_csrf',
            'csrf_token_id' => 'coppa',
        ]);
    }
}
