<?php

namespace App\Controller\Admin;

use App\Entity\Basket;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BasketCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Basket::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            yield AssociationField::new('buyer')
                ->setFormTypeOptions([
                    'by_reference' => true
                ])
                ->autocomplete(),
            yield AssociationField::new('product')
                ->setFormTypeOptions([
                    'by_reference' => true
                ])
                ->autocomplete(),
            yield ChoiceField::new('status')
                ->allowMultipleChoices()
                ->autocomplete()
                ->setChoices([  'En cours' => "en cours d'achat",
                        'Payé' => 'Payé',
                        "annulé" => "annulé"
                        ]
                ),
            yield TextField::new("token"),
            yield IntegerField::new("nombre"),
            yield DateTimeField::new('createdAt'),





        ];
    }

}
