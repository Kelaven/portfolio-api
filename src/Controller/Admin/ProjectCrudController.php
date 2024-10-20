<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;


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
                'HTML' => 'HTML',
                'CSS' => 'CSS',
                'Bootstrap' => 'Bootstrap',
                'Tailwind' => 'Tailwind',
                'JavaScript' => 'JavaScript',
                'TypeScript' => 'TypeScript',
                'React' => 'React',
                'Next.js' => 'Next.js',
                'PHP' => 'PHP',
                'Symfony' => 'Symfony',
                'WordPress' => 'WordPress',
                'Figma' => 'Figma',
                'Photoshop' => 'Photoshop',
                'Lightroom' => 'Lightroom',
                'GitHub' => 'GitHub',
                'Trello' => 'Trello',
            ])
            ->allowMultipleChoices(true);
        yield ImageField::new('picture')
            ->setBasePath('/uploads/images')
            ->setUploadDir('public/uploads/images')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false);
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
