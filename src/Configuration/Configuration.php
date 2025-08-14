<?php

namespace Xen3r0\JiraApiClient\Configuration;

final class Configuration implements ConfigurationInterface
{
    private string $host;

    private ?string $username = null;

    private ?string $password = null;

    public function __construct(string $host)
    {
        $this->host = $host;
    }

    public static function create(string $host, ?string $username = null, ?string $password = null): static
    {
        return (new static($host))
            ->setUsername($username)
            ->setPassword($password);
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): static
    {
        $this->host = $host;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }
}
