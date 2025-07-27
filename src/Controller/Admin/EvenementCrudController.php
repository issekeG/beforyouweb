<?php

namespace App\Controller\Admin;

use App\Entity\Evenement;
use App\Form\EventImageType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;


#[isGranted('ROLE_ADMIN')]
class EvenementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Evenement::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', label: 'Titre'),
            TextField::new('theme', label: "Thème de l'évenement"),
            DateField::new('evenementAt', label: "Date de l'évenement"),
            TextEditorField::new('description', label: "Description de l'événement"),
            SlugField::new('slug')->setTargetFieldName(['title'])->onlyOnIndex(),

            TextField::new('imageFile',"Affiche de l'evenement")->setFormType(VichImageType::class)->hideOnIndex()->setRequired(True),
            ImageField::new('image')->setBasePath('/upload/images/event')->OnlyOnIndex(),

            CollectionField::new('evenementImages', 'Ajouter les images')
                ->setEntryType(EventImageType::class)
                ->allowAdd(true)
                ->allowDelete(true)
                ->hideOnIndex(),

        ];
    }

}
