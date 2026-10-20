<?php

namespace Select2VanillaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Select2Type extends ChoiceType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'remove_icon_html' => '×',
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'select2';
    }
}
