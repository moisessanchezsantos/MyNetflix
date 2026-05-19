<?php

namespace App\Controller\Admin;

use App\Entity\ListaReproduccion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ListaReproduccionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ListaReproduccion::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nombre', 'Nombre'),
            TextField::new('descripcion', 'Descripcion'),
            DateTimeField::new('fechaCreacion', 'Fecha de Creacion'),
            AssociationField::new('usuario', 'Usuario'),
            AssociationField::new('peliculas', 'Peliculas'),
        ];
    }
}
