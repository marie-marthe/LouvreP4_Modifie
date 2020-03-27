<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mail', EmailType::class, array(
                'label'   =>'Votre adresse Mail',
                'required'=> true,
                'attr'    => array('placeholder' => 'exemple@mail.fr'),
            ))
            ->add('dateVisite')
            ->add('demijournee',ChoiceType::class, array(
                'choices'          => array(
                    'Journée'      => Client::TYPE_FULL_DAY,
                    'Demi-journée' => Client::TYPE_HALF_DAY
                ),
                'label'   => 'Type de billet',
                'expanded'=> true
            ))
            ->add('nbTicket', ChoiceType::class, array(
                'choices' => array(
                    '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10,
                    '11' => 11, '12' => 12, '13' => 13, '14' => 14, '15' => 15, '16' => 16, '17' => 17, '18' => 18,
                    '19' => 19, '20' => 20
                ),
                'label' => 'Nombre de Ticket',
                'required' => true
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
