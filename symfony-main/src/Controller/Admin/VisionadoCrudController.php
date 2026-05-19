<?php

namespace App\Controller\Admin;

use App\Entity\Visionado;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VisionadoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Visionado::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateTimeField::new('fecha', 'Fecha'),
            BooleanField::new('terminada', 'Terminada'),
            IntegerField::new('marcaTiempoMin', 'Minuto'),
            IntegerField::new('valoracion', 'Valoracion'),
            TextField::new('origen', 'Origen'),
            AssociationField::new('usuario', 'Usuario'),
            AssociationField::new('pelicula', 'Pelicula'),
            AssociationField::new('listaReproduccion', 'Lista de Reproduccion'),
        ];
    }
}
