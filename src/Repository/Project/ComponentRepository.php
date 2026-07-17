<?php

namespace Xen3r0\JiraApiClient\Repository\Project;

use Xen3r0\JiraApiClient\Exception\Project\ComponentMustBeExistsException;
use Xen3r0\JiraApiClient\Model\Project\Component;
use Xen3r0\JiraApiClient\Repository\AbstractRepository;

readonly class ComponentRepository extends AbstractRepository implements ComponentRepositoryInterface
{
    public function findById(string $id): ?Component
    {
        $response = $this->client->get(sprintf('component/%s', $id));

        $result = $this->deserialize($response, Component::class);
        if (!$result instanceof Component) {
            return null;
        }

        return $result;
    }

    public function add(Component $component): ?Component
    {
        $payload = $this->serialize($component, ['groups' => Component::WRITE_GROUP]);

        $response = $this->client->post('component', $payload);
        $result = $this->deserialize($response, Component::class);
        if (!$result instanceof Component) {
            return null;
        }

        return $result;
    }

    /**
     * @throws ComponentMustBeExistsException
     */
    public function update(Component $component): ?Component
    {
        if (!$component->getId()) {
            throw new ComponentMustBeExistsException();
        }

        $payload = $this->serialize($component, ['groups' => Component::WRITE_GROUP]);

        $response = $this->client->put(sprintf('component/%s', $component->getId()), $payload);
        $result = $this->deserialize($response, Component::class);
        if (!$result instanceof Component) {
            return null;
        }

        return $result;
    }

    public function remove(string $id): void
    {
        $this->client->delete(sprintf('component/%s', $id));
    }
}
