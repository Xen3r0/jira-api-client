<?php

namespace Xen3r0\JiraApiClient\Configuration;

final class Configuration implements ConfigurationInterface
{
    private string $host;

    private ?string $username = null;

    private ?string $password = null;

    private ?string $token = null;

    public function __construct(string $host)
    {
        $this->host = $host;
    }

    public static function createWithBasic(string $host, ?string $username = null, #[\SensitiveParameter] ?string $password = null): static
    {
        return (new static($host))
            ->setUsername($username)
            ->setPassword($password);
    }

    public static function createWithToken(string $host, #[\SensitiveParameter] string $token): static
    {
        return (new static($host))
            ->setToken($token);
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

    public function setPassword(#[\SensitiveParameter] ?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(#[\SensitiveParameter] ?string $token): static
    {
        $this->token = $token;

        return $this;
    }
}
