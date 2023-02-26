<?php

declare(strict_types=1);

namespace GChernikov\DoctrineOnFlushValidationBundle\Listener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EntityValidationListener
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    public function onFlush(OnFlushEventArgs $eventArgs): void
    {
        $unitOfWork = $eventArgs
            ->getObjectManager()
            ->getUnitOfWork();

        array_map(
            $this->validate(...),
            $unitOfWork->getScheduledEntityInsertions(),
        );

        array_map(
            $this->validate(...),
            $unitOfWork->getScheduledEntityUpdates(),
        );
    }

    private function validate(object $entity): void
    {
        $violations = $this->validator->validate($entity);

        if ($violations->count()) {
            throw new ValidationFailedException(
                value: $entity,
                violations: $violations,
            );
        }
    }
}
