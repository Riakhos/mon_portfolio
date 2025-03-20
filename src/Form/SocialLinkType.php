<?php

namespace App\Form;

use App\Entity\SocialLink;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocialLinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('platform', ChoiceType::class, [
                'choices' => [
                    'Facebook' => 'facebook',
                    'LinkedIn' => 'linkedin',
                    'Google' => 'google',
                    'Instagram' => 'instagram',
                    'GitHub' => 'github',
                    'Twitter' => 'twitter',
                    'YouTube' => 'youtube',
                    'Pinterest' => 'pinterest',
                    'Snapchat' => 'snapchat',
                    'TikTok' => 'tiktok',
                    'WhatsApp' => 'whatsapp',
                    'Discord' => 'discord',
                ],
                'label' => 'Réseau social',
                'attr' => [
                    'class' => 'platform-select'
                ],
            ])
            ->add('href', TextType::class, [
                'label' => 'Lien',
            ]);
            // ->add('about', EntityType::class, [
            //     'class' => About::class,
            //     'choice_label' => 'id',
            // ])
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SocialLink::class,
        ]);
    }
}
