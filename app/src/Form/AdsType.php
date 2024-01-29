<?php

namespace App\Form;

use App\Entity\Ads;
use App\Entity\Type;
use App\Entity\User;
use App\Entity\Equipment;
use App\Entity\Image;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;

class AdsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => ['class' => 'form-control']
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control']
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix pour la nuit',
                'attr' => ['class' => 'form-control']
            ])
            ->add('sleeping', IntegerType::class, [
                'label' => 'Nombre de couchage',
                'attr' => ['class' => 'form-control']
            ])
            ->add('size', IntegerType::class, [
                'label' => 'Taille en m²',
                'attr' => ['class' => 'form-control']
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => ['class' => 'form-control']
            ])
            // ->add('reservation_id', EntityType::class, [
            //     'class' => Reservation::class,
            //     'choice_label' => 'id',
            //     'label' => 'Reservation',
            //     'attr' => ['class' => 'form-control']
            // ])
            // ->add('user_id', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            //     'label' => 'User',
            //     'attr' => ['hidden' => 'true']
            // ])
            ->add('equipment_id', EntityType::class, [
                'class' => Equipment::class,
                'choice_label' => 'label',
                'label' => 'Equipement',
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'form-check',
                    'style' => 'display: flex;
                    flex-direction: column-reverse;
                    background-color: rgb(0, 86, 179, 0.1);
                    border-radius: 3px;
                    align-items: baseline;
                    ',
                ]
            ])
            
            ->add('typeId', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'label',
                'label' => 'Type de bien',
                'attr' => ['class' => 'form-control']
            ])
            
            // ->add('image', CollectionType::class, [
            //     'entry_type' => UploadImageType::class,
            //     'label' => false,
            //     'allow_add' => true,
            //     'prototype' => true,
            // ]);
            ->add('imageFile', FileType::class, [
                'label' => 'Image d\'illustration (JPG, PNG, jpeg, jpg)',
                'mapped' => false,
                'attr' => ['class' => 'form-control-file']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ads::class,
        ]);
    }
}
