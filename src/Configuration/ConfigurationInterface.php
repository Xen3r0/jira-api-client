<?php

namespace Xen3r0\JiraApiClient\Configuration;

interface ConfigurationInterface
{
    public function getHost(): string;

    public function setHost(string $host): static;

    public function getUsername(): ?string;

    public function setUsername(?string $username): static;

    public function getPassword(): ?string;

    public function setPassword(?string $password): static;
}
