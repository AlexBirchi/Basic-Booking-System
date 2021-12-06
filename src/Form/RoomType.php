<?php

namespace App\Form;

use App\Entity\Facility;
use App\Entity\Room;
use App\Repository\FacilityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adultsCapacity')
            ->add('childrenCapacity')
            ->add('roomType', EntityType::class, [
                'class' => \App\Entity\RoomType::class,
                'choice_label' => 'name',
            ])
            ->add('facilities', EntityType::class, [
                'class' => Facility::class,
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function (FacilityRepository $facilityRepository) {
                    return $facilityRepository->createQueryBuilder('f')
                        ->andWhere('f.isRoomFacility = ' . true);
                },
                'choice_label' => 'name',
            ])
            ->add('basePrice')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}
