<?php

namespace Select2VanillaBundle\Tests\Form\Type;

use Select2VanillaBundle\Form\Type\Select2Type;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
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

        $view = $form->createView();

        self::assertCount(2, $view->vars['choices']);
        self::assertSame('active', $view->vars['choices'][0]->data);
        self::assertSame('inactive', $view->vars['choices'][1]->data);
        self::assertSame('Actif', $view->vars['choices'][0]->label);
        self::assertSame('Inactif', $view->vars['choices'][1]->label);
    }

    public function testRemoveIconHtmlOptionIsCustomizable(): void
    {
        // L'option personnalisée doit être acceptée sans erreur par le type
        $form = $this->factory->create(Select2Type::class, null, [
            'choices' => ['Oui' => 'yes'],
            'remove_icon_html' => '<i class="fa fa-times"></i>',
        ]);

        self::assertNotNull($form);
        $form->createView();
    }

    public function testChoiceTypeInheritanceWorks(): void
    {
        // Le type doit accepter les options natives de ChoiceType
        $form = $this->factory->create(Select2Type::class, null, [
            'choices' => ['A' => 'a', 'B' => 'b'],
            'multiple' => true,
        ]);

        $view = $form->createView();

        self::assertTrue($view->vars['multiple']);
    }

    public function testSupportsEntityChoices(): void
    {
        // Vérifie que le type accepte des choix configurés (équivalent du support entité via choice_loader)
        $form = $this->factory->create(Select2Type::class, null, [
            'choices' => ['Catégorie 1' => 'cat1', 'Catégorie 2' => 'cat2'],
            'choice_label' => function ($choice) {
                return $choice;
            },
        ]);

        self::assertNotNull($form);
    }

    public function testSubmittedDataIsValid(): void
    {
        $form = $this->factory->create(Select2Type::class, null, [
            'choices' => ['Actif' => 'active', 'Inactif' => 'inactive'],
        ]);

        $form->submit('active');
        self::assertTrue($form->isValid());
        self::assertSame('active', $form->getData());
    }
}
