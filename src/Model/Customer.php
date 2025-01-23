<?php

namespace KaracaTech\UseInsider\Model;

class Customer
{
    private string $id;
    private string $email;
    private ?string $name;
    private array $attributes;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->name = $data['name'] ?? null;
        $this->attributes = $data;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}
