<?php

namespace App\Controller\Admin;

use App\Entity\ChatTeam;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ChatTeamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ChatTeam::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            yield AssociationField::new('user')
                ->setFormTypeOptions([
                    'by_reference' => false,
                ])
                ->autocomplete(),
            yield AssociationField::new('team')
                ->setFormTypeOptions([
                    'by_reference' => false,
                ])
                ->autocomplete(),
            yield TextField::new('message'),
            yield DateTimeField::new("createdAt"),

        ];
    }

}
