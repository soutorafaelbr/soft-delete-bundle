<?php
namespace Souto\SoftDeleteBundle\Filters;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

final class SoftDeleteFilter extends SQLFilter
{

    /**
     * @inheritDoc
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (! $targetEntity->hasField('deletedAt')) {
            return '';
        }

        if (strpos($this->getParameter('withThrashed'), 'enabled')) {
            return '';
        }

        return sprintf(
            '%s.deleted_at IS NULL 
            OR %s.deleted_at < ' . $this->getParameter('dateNow'),
            $targetTableAlias,
            $targetTableAlias
        );
    }
}