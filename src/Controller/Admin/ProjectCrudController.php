<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




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

    // Modifier le comportement par défaut de EasyAdmin, qui appelle la méthode remove() par défaut quand on supprime un élément (pour l'archiver au lieu de le supprimer) : 
    public function deleteEntity(EntityManagerInterface $entityManager, $entity): void
    {
        if ($entity instanceof Project) {
            // Au lieu de supprimer, marquer la date :
            $entity->setDeletedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
            $entityManager->persist($entity);
            $entityManager->flush();
        }
    }







    // TODO: Améliorer la notion d'archivage et implémenter une méthode de suppression définitive
    // // ! Configurer les actions sur les éléments :
    // public function configureActions(Actions $actions): Actions
    // {
    //     // * Pour le hard delete : 
    //     $hardDelete = Action::new('hardDelete', 'Suppression définitive', 'fa fa-trash')
    //         ->linkToCrudAction('hardDelete')
    //         ->setCssClass('text-danger'); // Pour le rendre rouge, comme le bouton "Delete"
    //     return $actions
    //         ->add(Crud::PAGE_INDEX, $hardDelete); // Ajoute le bouton en mode liste

    //     // * Pour l'archivage : 

    // }


    // /**
    //  * Méthode pour faire une suppression définitive
    //  */
    // public function hardDelete(EntityManagerInterface $entityManager, Request $request): Response
    // {
    //     $id = $request->query->get('entityId');
    //     $project = $entityManager->getRepository(Project::class)->find($id);

    //     if ($project) {
    //         $this->addFlash('success', 'Êtes-vous sûr de vouloir supprimer définitivement ce projet ?');
    //         $entityManager->remove($project);
    //         $entityManager->flush();
    //         $this->addFlash('success', 'Le projet a été supprimé définitivement.');
    //     } else {
    //         $this->addFlash('error', 'Projet non trouvé.');
    //     }

    //     return $this->redirect($this->generateUrl('admin'));
    // }
}
