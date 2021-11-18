<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse email :',
            ]) 
           
            ->add('password', PasswordType::class, [
                'label' => 'Votre mot de passe :',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Inscription',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => Utilisateur::class,
            'data' => new Utilisateur(),
            'methode' => 'GET',
        ]);
    }
}
