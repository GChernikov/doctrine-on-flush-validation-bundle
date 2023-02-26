<?php

declare(strict_types=1);

namespace GChernikov\DoctrineOnFlushValidationBundle;

use GChernikov\DoctrineOnFlushValidationBundle\DependencyInjection\DoctrineOnFlushValidationExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DoctrineOnFlushValidationBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new DoctrineOnFlushValidationExtension();
    }
}
