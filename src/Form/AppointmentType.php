<?php

namespace App\Form;

use App\Entity\Appointment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('appointmentAt', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('start', TimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('end', TimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('salon', HiddenType::class)
            ->add('token', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
            'salon_id' => null,
            'salon' => null
        ]);
    }
}
