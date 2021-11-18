<?php

namespace App\Form;

use App\DTO\SearchCriteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchCriteriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                  'label'=> 'Par titre :',
                  'required' => false,
            ])
            ->add('auteur', TextType::class,[
                'label'=> 'Par auteur :',
                'required' => false,
            ])            
            ->add('description', TextType::class,[
                'label'=> 'Par description :',
                'required' => false,
            ])  
                     
            ->add('categorie' , TextType::class,[
                'label'=> 'Par categorie :',
                'required' => false,
            ])
            ->add('revendeur', TextType::class,[
                'label'=> 'Par revendeur :',
                'required' => false,
            ])
            ->add('minPrix', MoneyType::class, [
                'label'=> 'Par prix minimum :',
                'required' => false,
            ])
            ->add('maxPrix', MoneyType::class,[
                'label'=> 'Par prix maximum :',
                'required' => false,
            ])
            ->add('page', NumberType::class,[
                'label' => 'Page :'
            ])
            ->add('limit',NumberType::class,[
                'label' => 'Nombre de résultat maximum :'
            ] )
            ->add('orderBy', ChoiceType::class,[
                'label' => 'Trier par :',
                'choices' => [
                    'Titre' => 'titre',
                    'Auteur' => 'auteur',
                    'Revendeur' => 'revendeur',
                    'Prix Minimum' => 'minPrix',
                    'Prix Maximum' => 'maxPrix',
                    'Date de mise à jour' => 'datedemisejour',
                ]
            ])
            ->add('direction',ChoiceType::class,[

                'label' => 'Sens du trie :',
                'choices' => [
                    'Croissant' => 'ASC',
                    'Decroissant' => 'DESC',
                ]
                ])

            ->add('submit', SubmitType::class,[
                'label' => 'Rechercher',
            ]);

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchCriteria::class,
            'data' => new SearchCriteria(),
            'method' => 'GET',
        ]);
    }
}
