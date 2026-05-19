<?php

namespace App\Controller\Admin;

use App\Entity\Usuario;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UsuarioCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Usuario::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nombre', 'Nombre'),
            TextField::new('email', 'Email'),
            TextField::new('passwordHash', 'Password Hash')->hideOnIndex(),
            DateTimeField::new('fechaRegistro', 'Fecha de Registro'),
            TextField::new('estado', 'Estado'),
            TextField::new('metodoPagoTipo', 'Tipo de Pago'),
            TextField::new('metodoPagoEnmascarado', 'Pago Enmascarado'),
        ];
    }
}
