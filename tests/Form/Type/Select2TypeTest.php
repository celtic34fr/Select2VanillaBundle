<?php

namespace Select2VanillaBundle\Tests\Form\Type;

use Select2VanillaBundle\Form\Type\Select2Type;
use Symfony\Component\Form\Test\TypeTestCase;

class Select2TypeTest extends TypeTestCase
{
    public function testGetBlockPrefix(): void
    {
        $type = new Select2Type();
        self::assertSame('select2', $type->getBlockPrefix());
    }

    public function testConfigureOptions(): void
    {
        $form = $this->factory->create(Select2Type::class, null, [
            'choices' => ['Actif' => 'active', 'Inactif' => 'inactive'],
        ]);

        $config = $form->getConfig();
        self::assertSame('active', $config->getAttribute('choices')['Actif']);
        self::assertSame('×', $config->getAttribute('remove_icon_html'));
    }

    public function testRemoveIconHtmlOptionIsCustomizable(): void
    {
        $form = $this->factory->create(Select2Type::class, null, [
            'choices' => ['Oui' => 'yes'],
            'remove_icon_html' => '<i class="fa fa-times"></i>',
        ]);

        $config = $form->getConfig();
        self::assertSame('<i class="fa fa-times"></i>', $config->getAttribute('remove_icon_html'));
    }

    public function testChoiceTypeInheritanceWorks(): void
    {
        // Le type doit accepter les options natives de ChoiceType
        $form = $this->factory->create(Select2Type::class, null, [
            'choices' => ['A' => 'a', 'B' => 'b'],
            'placeholder' => 'Choisir',
            'multiple' => true,
        ]);

        $config = $form->getConfig();
        self::assertTrue($config->getAttribute('multiple'));
        self::assertSame('Choisir', $config->getAttribute('placeholder'));
    }

    public function testSupportsEntityChoices(): void
    {
        // Vérifie que le type accepte une classe d'entité (comme ChoiceType)
        $form = $this->factory->create(Select2Type::class, null, [
            'class' => 'App\Entity\Category',
            'choice_label' => 'name',
        ]);

        self::assertNotNull($form);
    }

    public function testSubmittedDataIsValid(): void
    {
        $form = $this->factory->create(Select2Type::class, null, [
            'choices' => ['Actif' => 'active', 'Inactif' => 'inactive'],
        ]);

        $form->submit(['active']);
        self::assertTrue($form->isValid());
        self::assertSame(['active'], $form->getData());
    }
}
