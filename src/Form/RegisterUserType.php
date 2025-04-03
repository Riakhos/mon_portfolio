<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse mail <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez fournir une adresse mail.'
                    ]),
                    new Email([
                        'message' => 'Adresse email invalide.'
                    ])
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Indiquez votre adresse mail',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez fournir un mot de passe.'
                    ]),
                    new Length([
                        'min' => 12,
                        'max' => 30,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le mot de passe ne peut pas dépasser {{ limit }} caractères.'
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{12,30}$/',
                        'message' => 'Le mot de passe doit contenir au moins une lettre et un chiffre.',
                    ])
                ],
                'first_options'  => [
                    'label' => 'Votre mot de passe',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Choisissez votre mot de passe',
                        'autocomplete' => 'off'
                    ],
                    'hash_property_path' => 'password'
                ],
                'second_options' => [
                    'label' => 'Confirmer votre mot de passe',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Confirmez votre mot de passe',
                        'autocomplete' => 'off'
                    ]
                ],
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'mapped' => false,
            ])
            ->add('username', TextType::class, [
                'label' => 'Votre pseudo',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez fournir votre pseudo.'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 30,
                        'minMessage' => 'Le pseudo doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le pseudo ne peut pas dépasser {{ limit }} caractères.'
                    ]),
                    new Regex([
                        'pattern' => "/^[A-Za-zÀ-ÖØ-öø-ÿ0-9'&.-]{2,30}$/",
                        'message' => "Ceci n'est pas un pseudo valide"
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Indiquez votre pseudo',
                    'autocomplete' => 'off'
                ]                   
            ])
            ->add('captcha', CheckboxType::class, [
                'label' => 'Vérifiez que vous êtes un humain.',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez vérifier que vous êtes un humain.'
                    ])
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-info btn-block d-block mx-auto',
                    'data-loading-text' => 'Chargement...'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints'=> [
                new UniqueEntity([
                    'entityClass' => User::class,
                    'fields' => 'email',
                    'fields' => 'username',
                    'message' => 'Cette adresse mail est déjà utilisée.',
                    'message' => 'Ce pseudo est déjà utilisée.'
                ])
            ],
            'data_class' => User::class,
        ]);
    }
}
