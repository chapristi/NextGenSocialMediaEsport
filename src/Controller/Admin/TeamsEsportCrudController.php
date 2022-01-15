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

            TextField::new(propertyName:'name'),
            SlugField::new(propertyName: "slug")->setTargetFieldName(fieldName: "name"),
            TextEditorField::new(propertyName:'description'),
            DateTimeField::new(propertyName:"createdAt"),
            TextField::new(propertyName:"token"),
        ];
    }

}
