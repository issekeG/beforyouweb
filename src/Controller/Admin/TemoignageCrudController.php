<?php

namespace App\Controller\Admin;

use App\Entity\Temoignage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TemoignageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Temoignage::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),

            TextField::new('fullname', label: "Prénom & Nom")
                ->setRequired(true)
                ->setFormTypeOption('attr', ['placeholder' => 'Ex: Gickel OKABI']),

            TextField::new('titre', label: "Poste et entreprise")
                ->setRequired(true)
                ->setFormTypeOption('attr', ['placeholder' => 'Ex: Analyste chez Antalasoft']),

            TextEditorField::new('description', label: "Témoignage")
                ->setRequired(true)
                ->setFormTypeOption('attr', ['placeholder' => 'Le retour d’expérience client...']),

            // Champ d'upload (uniquement en création ou édition)
            TextField::new('photoFile', "Photo de profil")
                ->setFormType(VichImageType::class)
                ->onlyOnForms()->setRequired(true),

            // Affichage de l'image existante dans le formulaire
            ImageField::new('photo')
                ->setBasePath("/upload/images/temoignage")
                ->onlyOnIndex(),


        ];

    }

}
