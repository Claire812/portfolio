<?php

namespace App\Form;

use App\Entity\Language;
use App\Entity\Project;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du projet',
                'required' => true,
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => true,
            ])
            ->add('date',  DateType::class, [
                'label' => 'Date du projet',
                'years' => range(2020, 2023,1),
                'format' => 'dd-MM-yyyy',
                'required' => true,
            ])
            ->add('link', TextType::class, [
                'label' => 'Lien',
                'required' => false,
            ])
            ->add('client', TextType::class, [
                'label' => 'Nom du client',
                'required' => false,
            ])
            ->add('language', EntityType::class, [
                'choice_label' => 'name',
                'label_attr' => [
                    'class' => 'checkbox-custom',
                ],
                'class' => Language::class,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('poster', TextType::class, [
                'label' => 'Image',
                'required' => false,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
