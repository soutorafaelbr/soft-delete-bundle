<?php
namespace Souto\SoftDeleteBundle\Traits;

use DateTimeInterface;

trait SoftDeletable
{
    /**
     * @ORM\Column(type="datetime", name="deleted_at", nullable=true)
     */
    private $deletedAt;

    /**
     * @return DateTimeInterface|null
     */
    public function getDeletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    /**
     * @param DateTimeInterface $deletedAt
     * @return $this
     */
    public function setDeletedAt(DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

}