<?php
declare(strict_types=1);

namespace App\Specification\Composite;

abstract class CompositeSpecification implements SpecificationInterface
{
    public function and(SpecificationInterface $specification): AndSpecification
    {
        return new AndSpecification($this, $specification);
    }
}
