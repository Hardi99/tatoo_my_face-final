<?php

namespace App\Form;

use App\Entity\TatooStyle;
use App\Entity\SalonSearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalonSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tatoo_styles', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => TatooStyle::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('address', null, [
                'label' => false,
                'required' => false,
            ])
            ->add('distance', ChoiceType::class, [
                'choices' => [
                    '10 km' => 10,
                    '1000 km' => 1000
                ]
            ])
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SalonSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
