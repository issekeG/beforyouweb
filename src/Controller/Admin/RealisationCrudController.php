<?php

namespace App\Controller\Admin;

use App\Entity\Realisation;
use App\Form\RealisationImageType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;


#[isGranted('ROLE_ADMIN')]
class RealisationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Realisation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', label: 'Titre')->setRequired(true),
            AssociationField::new('category', 'Catégorie')->setRequired(true),
            TextField::new('client', label: 'Client')->setRequired(true),
            DateField::new('projetAt', label: 'Date de la réalisation')->setRequired(true),
            SlugField::new('slug')->setTargetFieldName(['title'])->onlyOnIndex(),
            TextEditorField::new('description', label: 'Description de la réalisation')->setRequired(true),
            CollectionField::new('realisationImages', 'Ajouter les images')
                ->setEntryType(RealisationImageType::class)
                ->allowAdd(true)
                ->allowDelete(true)
                ->hideOnIndex(),

        ];
    }

}
