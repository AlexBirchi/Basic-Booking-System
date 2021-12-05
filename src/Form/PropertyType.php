<?php

namespace App\Form;

use App\Entity\Facility;
use App\Entity\Property;
use App\Repository\FacilityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('propertyType', EntityType::class, [
                'class' => \App\Entity\PropertyType::class,
                'choice_label' => 'name',
            ])
            ->add('location', LocationType::class, [
                'label' => false,
            ])
            ->add('facilities', EntityType::class, [
                'class' => Facility::class,
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function (FacilityRepository $facilityRepository) {
                    return $facilityRepository->createQueryBuilder('f')
                        ->andWhere('f.isPropertyFacility = ' . true);
                },
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
