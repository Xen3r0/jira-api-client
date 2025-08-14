<?php

namespace Xen3r0\JiraApiClient\Model\Avatar;

use Symfony\Component\Serializer\Attribute\SerializedName;

class Urls
{
    #[SerializedName('16x16')]
    private ?string $x16 = null;

    #[SerializedName('24x24')]
    private ?string $x24 = null;

    #[SerializedName('32x32')]
    private ?string $x32 = null;

    #[SerializedName('48x48')]
    private ?string $x48 = null;

    public function getX16(): ?string
    {
        return $this->x16;
    }

    public function setX16(?string $x16): static
    {
        $this->x16 = $x16;

        return $this;
    }

    public function getX24(): ?string
    {
        return $this->x24;
    }

    public function setX24(?string $x24): static
    {
        $this->x24 = $x24;

        return $this;
    }

    public function getX32(): ?string
    {
        return $this->x32;
    }

    public function setX32(?string $x32): static
    {
        $this->x32 = $x32;

        return $this;
    }

    public function getX48(): ?string
    {
        return $this->x48;
    }

    public function setX48(?string $x48): static
    {
        $this->x48 = $x48;

        return $this;
    }
}
