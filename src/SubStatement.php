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

use DateTime;
use InvalidArgumentException;

/**
 * A {@link Statement} included as part of a parent Statement.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final class SubStatement extends StatementObject
{
    private Verb $verb;
    private Actor $actor;
    private StatementObject $object;
    private ?Result $result;
    private ?DateTime $created;
    private ?Context $context;
    /**
     * @var array<int, Attachment>|null
     */
    private ?array $attachments;

    /**
     * @param array<int, Attachment>|null $attachments
     */
    public function __construct(
        Actor $actor,
        Verb $verb,
        StatementObject $object,
        ?Result $result = null,
        ?Context $context = null,
        ?DateTime $created = null,
        ?array $attachments = null
    ) {
        if ($object instanceof SubStatement) {
            throw new InvalidArgumentException('Nesting sub statements is forbidden by the xAPI spec.');
        }

        $this->actor = $actor;
        $this->verb = $verb;
        $this->object = $object;
        $this->result = $result;
        $this->created = $created;
        $this->context = $context;
        $this->attachments = null !== $attachments ? array_values($attachments) : null;
    }

    public function withActor(Actor $actor): self
    {
        $subStatement = clone $this;
        $subStatement->actor = $actor;

        return $subStatement;
    }

    public function withVerb(Verb $verb): self
    {
        $subStatement = clone $this;
        $subStatement->verb = $verb;

        return $subStatement;
    }

    public function withObject(StatementObject $object): self
    {
        $subStatement = clone $this;
        $subStatement->object = $object;

        return $subStatement;
    }

    public function withResult(?Result $result): self
    {
        $subStatement = clone $this;
        $subStatement->result = $result;

        return $subStatement;
    }

    public function withCreated(?DateTime $created = null): self
    {
        $statement = clone $this;
        $statement->created = $created;

        return $statement;
    }

    public function withContext(?Context $context): self
    {
        $subStatement = clone $this;
        $subStatement->context = $context;

        return $subStatement;
    }

    /**
     * @param array<int, Attachment>|null $attachments
     */
    public function withAttachments(?array $attachments = null): self
    {
        $statement = clone $this;
        $statement->attachments = null !== $attachments ? array_values($attachments) : null;

        return $statement;
    }

    /**
     * Returns the Statement's {@link Verb}.
     */
    public function getVerb(): Verb
    {
        return $this->verb;
    }

    /**
     * Returns the Statement's {@link Actor}.
     */
    public function getActor(): Actor
    {
        return $this->actor;
    }

    /**
     * Returns the Statement's {@link StatementObject}.
     */
    public function getObject(): StatementObject
    {
        return $this->object;
    }

    /**
     * Returns the {@link Activity} {@link Result}.
     */
    public function getResult(): ?Result
    {
        return $this->result;
    }

    /**
     * Returns the timestamp of when the events described in this statement
     * occurred.
     */
    public function getCreated(): ?DateTime
    {
        return $this->created;
    }

    /**
     * Returns the {@link Statement} {@link Context}.
     */
    public function getContext(): ?Context
    {
        return $this->context;
    }

    /**
     * @return array<int, Attachment>|null
     */
    public function getAttachments(): ?array
    {
        return $this->attachments;
    }

    /**
     * Tests whether this Statement is a void Statement (i.e. it voids
     * another Statement).
     */
    public function isVoidStatement(): bool
    {
        return $this->verb->isVoidVerb();
    }

    /**
     * {@inheritdoc}
     */
    public function equals(StatementObject $object): bool
    {
        if (!$object instanceof SubStatement) {
            return false;
        }

        if (!$this->actor->equals($object->actor)) {
            return false;
        }

        if (!$this->verb->equals($object->verb)) {
            return false;
        }

        if (!$this->object->equals($object->object)) {
            return false;
        }

        if (null === $this->result && null !== $object->result) {
            return false;
        }

        if (null !== $this->result && null === $object->result) {
            return false;
        }

        if (null !== $this->result && !$this->result->equals($object->result)) {
            return false;
        }

        if ($this->created != $object->created) {
            return false;
        }

        if (null !== $this->context xor null !== $object->context) {
            return false;
        }

        if (null !== $this->context && null !== $object->context && !$this->context->equals($object->context)) {
            return false;
        }

        if (null !== $this->attachments xor null !== $object->attachments) {
            return false;
        }

        if (null !== $this->attachments && null !== $object->attachments) {
            if (count($this->attachments) !== count($object->attachments)) {
                return false;
            }

            foreach ($this->attachments as $key => $attachment) {
                if (!$attachment->equals($object->attachments[$key])) {
                    return false;
                }
            }
        }

        return true;
    }
}
