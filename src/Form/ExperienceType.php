<?php

namespace App\Form;

use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'expérience',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez indiquer le titre de l\'expérience.'
                    ]),
                    new Length([
                        'min' => 12,
                        'max' => 30,
                        'minMessage' => 'Le titre de l\'expérience doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le titre de l\'expérience ne peut pas dépasser {{ limit }} caractères.'
                    ]),
                    new Regex([
                        'pattern' => "/^[A-Za-zÀ-ÖØ-öø-ÿ0-9'&.-]{12,30}$/",
                        'message' => "Ceci n'est pas un titre d\'expérience valide"
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de l\'expérience',
                'constraints' => [
                    new NotBlank([
                        'message' => 'La description ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 500,
                        'minMessage' => 'La description doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'La description ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^[\p{L}0-9\s.,!?\'"()\-]{10,500}$/u',
                        'message' => 'La description contient des caractères non autorisés.',
                    ]),
                ],
            ])
            ->add('titleJob', TextType::class, [
                'label' => 'Titre de l\'expérience',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez indiquer le titre de l\'expérience.'
                    ]),
                    new Length([
                        'min' => 12,
                        'max' => 30,
                        'minMessage' => 'Le titre de l\'expérience doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le titre de l\'expérience ne peut pas dépasser {{ limit }} caractères.'
                    ]),
                    new Regex([
                        'pattern' => "/^[A-Za-zÀ-ÖØ-öø-ÿ0-9'&.-]{12,30}$/",
                        'message' => "Ceci n'est pas un titre d\'expérience valide"
                    ]),
                ],
            ])
            ->add('descriptionJob', TextareaType::class, [
                'label' => 'Description de l\'expérience',
                'constraints' => [
                    new NotBlank([
                        'message' => 'La description ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 500,
                        'minMessage' => 'La description doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'La description ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^[\p{L}0-9\s.,!?\'"()\-]{10,500}$/u',
                        'message' => 'La description contient des caractères non autorisés.',
                    ]),
                ],
            ])
            ->add('institution', TextType::class, [
                'label' => 'Institution',
                'required' => false,
            ])
            ->add('startDate', DateType::class, [
                'label' => 'Date de début',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('endDate', DateType::class, [
                'label' => 'Date de fin',
                'widget' => 'single_text',
                'required' => false,
            ])
            // ->add('about', EntityType::class, [
            //     'class' => About::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
