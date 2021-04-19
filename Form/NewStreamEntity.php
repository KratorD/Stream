<?php

/*
 * This file is part of the Krator\StreamModule package.
 *
 * Copyright Krator.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Krator\StreamModule\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;

class NewStreamEntity extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', SearchType::class, ['mapped' => false])
			->add('gameId')
            ->add('name')
            ->add('boxArtUrl')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Krator\StreamModule\Entity\StreamEntity'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'krator_streammodule_streamentitytype';
    }
}
