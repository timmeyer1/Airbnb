<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

// class RegistrationFormType extends AbstractType
// {
//     public function buildForm(FormBuilderInterface $builder, array $options): void
//     {
//         $builder
//             ->add('email', EmailType::class, [
//                 'label' => 'Votre email',
//                 'attr' => [
//                     'class' => 'mt-5',
//                     'placeholder' => 'Entrez votre email'
//                 ]
//             ])
//             ->add('agreeTerms', CheckboxType::class, [
//                 'label' => 'J\'ai lu et j\'accepte les conditions',
//                 'mapped' => false,
//                 'constraints' => [
//                     new IsTrue([
//                         'message' => 'You should agree to our terms.',
//                     ]),
//                 ],
//             ])
//             ->add('plainPassword', PasswordType::class, [
//                 // instead of being set onto the object directly,
//                 // this is read and encoded in the controller
//                 'mapped' => false,
//                 'attr' => ['autocomplete' => 'new-password'],
//                 'constraints' => [
//                     new NotBlank([
//                         'message' => 'Entrez un mot de passe',
//                     ]),
//                     new Length([
//                         'min' => 6,
//                         'minMessage' => 'Your password should be at least {{ limit }} characters',
//                         // max length allowed by Symfony for security reasons
//                         'max' => 4096,
//                     ]),
//                 ],
//             ]);
//     }

//     public function configureOptions(OptionsResolver $resolver): void
//     {
//         $resolver->setDefaults([
//             'data_class' => User::class,
//         ]);
//     }
// }

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'attr' => [
                    'class' => 'mt-5',
                    'placeholder' => 'Entrez votre email'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'attr' => [
                    'class' => 'mt-3',
                    'placeholder' => 'Entrez votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'class' => 'mt-3',
                    'placeholder' => 'Entrez votre nom'
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Votre numéro de téléphone',
                'attr' => [
                    'class' => 'mt-3',
                    'placeholder' => 'Entrez votre numéro de téléphone'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Votre adresse',
                'attr' => [
                    'class' => 'mt-3',
                    'placeholder' => 'Entrez votre adresse'
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'J\'ai lu et j\'accepte les conditions',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}