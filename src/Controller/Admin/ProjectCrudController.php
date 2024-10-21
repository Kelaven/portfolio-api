<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield TextEditorField::new('description');
        yield ChoiceField::new('languages')
            ->setChoices([
                'HTML' => 'html',
                'CSS' => 'css',
                'Bootstrap' => 'bootstrap',
                'Tailwind' => 'tailwind',
                'JavaScript' => 'javascript',
                'React' => 'react',
                'Next.js' => 'nextjs',
                'PHP' => 'php',
                'Symfony' => 'symfony',
                'WordPress' => 'wordpress',
                'Figma' => 'figma',
                'Photoshop' => 'photoshop',
                'Lightroom' => 'lightroom',
                'GitHub' => 'github',
                'Trello' => 'trello',
                'Microsoft Office' => 'microsoft_office',
            ])
            ->allowMultipleChoices(true);

        $createdAt = DateTimeField::new('created_at')->setFormTypeOptions([
            'years' => range(date('Y'), date('Y') + 5),
            'widget' => 'single_text',
        ]);

        if (Crud::PAGE_EDIT === $pageName) {
            yield $createdAt->setFormTypeOption('disabled', true); // Désactiver le champ en mode édition
        } else {
            yield $createdAt; // Afficher normalement lors de la création
        }

        yield DateTimeField::new('updated_at')->hideOnForm(); // Afficher uniquement en lecture seule
        yield DateTimeField::new('deleted_at')->hideOnForm(); // Afficher uniquement en lecture seule
    }
}
