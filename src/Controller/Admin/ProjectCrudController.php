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
use Doctrine\ORM\EntityManagerInterface;


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
                'GSAP' => 'GSAP',
                'TypeScript' => 'TypeScript',
                'JSX' => 'JSX',
                'React' => 'React',
                'Next.js' => 'Next.js',
                'Three.js' => 'Three.js',
                'PHP' => 'PHP',
                'Symfony' => 'Symfony',
                'MySQL' => 'MySQL',
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

        yield DateTimeField::new('updated_at')->hideOnForm();
        yield DateTimeField::new('deleted_at')->hideOnForm();
    }

    // Modifier le comportement par défaut de EasyAdmin, qui appelle la méthode remove() par défaut quand on supprime un élément : 
    public function deleteEntity(EntityManagerInterface $entityManager, $entity): void
    {
        if ($entity instanceof Project) {
            // Au lieu de supprimer, marquer comme supprimé :
            $entity->setDeletedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
            $entityManager->persist($entity);
            $entityManager->flush();
        }
    }
}
