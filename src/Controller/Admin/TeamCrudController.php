<?php

namespace App\Controller\Admin;

use App\Entity\Team;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TeamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Team::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $imagePath = '/upload/images/team';

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('fullname', label: "Prénom & Nom"),
            TextField::new('titre', label: "Position"),
            TextEditorField::new('description', "Description"),

            // Champ d'upload (uniquement en création ou édition)
            TextField::new('photoFile', "Photo de profil")
                ->setFormType(VichImageType::class)
                ->onlyOnForms(),

            // Affichage de l'image existante dans le formulaire
            ImageField::new('photo')
                ->setBasePath($imagePath)
                ->onlyOnDetail(),

            // Affichage dans la liste
            ImageField::new('photo')
                ->setBasePath($imagePath)
                ->onlyOnIndex(),

            TextField::new('facebook', label: "Profil Facebook"),
            TextField::new('linkedin', label: "Profil LinkedIn"),
            TextField::new('twitter', label: "Profil X (Twitter)"),
        ];
    }


}
