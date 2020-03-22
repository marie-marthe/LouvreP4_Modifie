<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label'=>'Nom',
                'attr' => array('class' => 'Nom', 'placeholder' => 'Votre nom')
            ))
            ->add('lastName', TextType::class, array(
                'label'=>'Prénom',
                'attr' => array('class' => 'prenom', 'placeholder' => 'Votre prénom')
            ))
            ->add('birthday', DateType::class, array(
                'label'  => 'Date de naissance',
                'format' => 'dd/MM/yyyy',
                'attr'   => array('class' => 'Daten', 'placeholder' => 'JJ/MM/AAAA'),

            ))
            ->add('country', CountryType::class,array(
                'label'=>'Pays de résidence',
                'attr' => array('class' => 'pays')
            ))
            ->add('reduc', CheckboxType::class,array(
                'required' => false,
                'label'    => 'Tarif réduit',
                'attr'     => array('class', 'discount')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
