<?php

/*
 * This file is part of the xAPI package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xabbuh\XApi\Model;

/**
 * The Actor of a {@link Statement}.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
abstract class Actor extends StatementObject
{
    private ?InverseFunctionalIdentifier $iri;
    private ?string $name;

    public function __construct(?InverseFunctionalIdentifier $iri = null, ?string $name = null)
    {
        $this->iri = $iri;
        $this->name = $name;
    }

    /**
     * Returns the Actor's {@link InverseFunctionalIdentifier inverse functional identifier}.
     */
    public function getInverseFunctionalIdentifier(): ?InverseFunctionalIdentifier
    {
        return $this->iri;
    }

    /**
     * Returns the name of the {@link Agent} or {@link Group}.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Checks if another actor is equal.
     *
     * Two actors are equal if and only if all of their properties are equal.
     */
    public function equals(StatementObject $object): bool
    {
        if (!parent::equals($object)) {
            return false;
        }

        if (!$object instanceof Actor) {
            return false;
        }

        if ($this->name !== $object->name) {
            return false;
        }

        if (null !== $this->iri xor null !== $object->iri) {
            return false;
        }

        if (null !== $this->iri && null !== $object->iri && !$this->iri->equals($object->iri)) {
            return false;
        }

        return true;
    }
}
