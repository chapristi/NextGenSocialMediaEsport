<?php

namespace App\Controller\Admin;

use App\Entity\UserJoinTeam;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;


class UserJoinTeamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserJoinTeam::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            AssociationField::new('user'),
            yield AssociationField::new('user')
                ->setFormTypeOptions([
                    'by_reference' => true
                ])
                ->autocomplete(),
            yield AssociationField::new('team')
                ->setFormTypeOptions([
                    'by_reference' => true,
                ])
                ->autocomplete(),
            yield ArrayField::new("role"),
            yield BooleanField::new('isValidated'),
            yield DateTimeField::new('createdAt'),

        ];
    }

}
