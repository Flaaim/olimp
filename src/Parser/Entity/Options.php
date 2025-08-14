<?php

namespace App\Parser\Entity;

use ArrayObject;
use Webmozart\Assert\Assert;

class Options
{
    private ArrayObject $options;
    public function __construct(array $options = [])
    {
        Assert::isArray($options);
        $this->options = new ArrayObject($options);
    }

    public function toArray(): array
    {
        return $this->options->getArrayCopy();
    }
    public function getValue(string $key): mixed
    {
        if(!$this->options->offsetExists($key)){
            throw new \InvalidArgumentException("Option key does not exist.");
        }
        return $this->options->offsetGet($key);
    }

    public function has(string $key): bool
    {
        return $this->options->offsetExists($key);
    }

    public function withValue(string $key, mixed $value): self
    {
        $clone = clone $this;
        $clone->options->offsetSet($key, $value);
        return $clone;
    }
}
