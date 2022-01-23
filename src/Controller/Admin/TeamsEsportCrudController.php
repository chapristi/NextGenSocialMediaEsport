<?php

namespace App\Controller\Admin;

use App\Entity\TeamsEsport;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TeamsEsportCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TeamsEsport::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            yield TextField::new(propertyName:'name'),
            yield SlugField::new(propertyName: "slug")->setTargetFieldName(fieldName: "name"),
            yield TextEditorField::new(propertyName:'description'),
            yield DateTimeField::new(propertyName:"createdAt"),
            yield TextField::new(propertyName:"token"),
        ];
    }

}
