<?php

namespace Xen3r0\JiraApiClient\Tests\Repository\Issue;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Xen3r0\JiraApiClient\Http\JiraClient;
use Xen3r0\JiraApiClient\Model\Issue\CustomFieldContextOptionsList;
use Xen3r0\JiraApiClient\Model\Issue\CustomFieldOption;
use Xen3r0\JiraApiClient\Repository\Issue\CustomFieldOptionRepository;
use Xen3r0\JiraApiClient\Tests\Repository\AbstractRepositoryTestCase;

class CustomFieldOptionRepositoryTest extends AbstractRepositoryTestCase
{
    public function testFindAll(): void
    {
        $content = $this->getFixtureContent('Issue/get_field_context_options.json');
        $jiraClient = $this->createMock(JiraClient::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('field/customfield_10000/context/10177/option')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new CustomFieldOptionRepository($jiraClient);
        $actual = $repository->findAll('customfield_10000', 10177);
        $this->assertNotEmpty($actual->getValues());
    }

    public function testFindById(): void
    {
        $content = $this->getFixtureContent('Issue/get_field_context_options.json');
        $jiraClient = $this->createMock(JiraClient::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('customFieldOption/10001')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new CustomFieldOptionRepository($jiraClient);
        $repository->findById('10001');
    }

    public function testAdd(): void
    {
        $option1 = (new CustomFieldOption())
            ->setValue('Enabled feature');
        $option2 = (new CustomFieldOption())
            ->setValue('Disabled feature')
            ->setDisabled(true);
        $payload = [
            'options' => [
                ['value' => 'Enabled feature', 'disabled' => false],
                ['value' => 'Disabled feature', 'disabled' => true],
            ],
        ];
        $result = [...$payload];
        $result['options'][0]['id'] = '10001';
        $result['options'][1]['id'] = '10002';

        $jiraClient = $this->createMock(JiraClient::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('post')
            ->with('field/customfield_10000/context/10177/option', json_encode($payload))
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode($result));

        $repository = new CustomFieldOptionRepository($jiraClient);
        $actual = $repository->add('customfield_10000', 10177, [$option1, $option2]);
        $this->assertInstanceOf(CustomFieldContextOptionsList::class, $actual);
        $this->assertCount(2, $actual->getOptions());
        $this->assertEquals('10001', $actual->getOptions()[0]->getId());
        $this->assertEquals($option1->getValue(), $actual->getOptions()[0]->getValue());
        $this->assertEquals($option1->getDisabled(), $actual->getOptions()[0]->getDisabled());
        $this->assertEquals('10002', $actual->getOptions()[1]->getId());
        $this->assertEquals($option2->getValue(), $actual->getOptions()[1]->getValue());
        $this->assertEquals($option2->getDisabled(), $actual->getOptions()[1]->getDisabled());
    }

    public function testUpdate(): void
    {
        $option1 = (new CustomFieldOption())
            ->setId('10001')
            ->setValue('Enabled feature');
        $option2 = (new CustomFieldOption())
            ->setId('10002')
            ->setValue('Disabled feature')
            ->setDisabled(true);
        $payload = [
            'options' => [
                ['id' => '10001', 'value' => 'Enabled feature', 'disabled' => false],
                ['id' => '10002', 'value' => 'Disabled feature', 'disabled' => true],
            ],
        ];
        $result = [...$payload];

        $jiraClient = $this->createMock(JiraClient::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('put')
            ->with('field/customfield_10000/context/10177/option', json_encode($payload))
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode($result));

        $repository = new CustomFieldOptionRepository($jiraClient);
        $actual = $repository->update('customfield_10000', 10177, [$option1, $option2]);
        $this->assertInstanceOf(CustomFieldContextOptionsList::class, $actual);
        $this->assertCount(2, $actual->getOptions());
        $this->assertEquals($option1->getId(), $actual->getOptions()[0]->getId());
        $this->assertEquals($option1->getValue(), $actual->getOptions()[0]->getValue());
        $this->assertEquals($option1->getDisabled(), $actual->getOptions()[0]->getDisabled());
        $this->assertEquals($option2->getId(), $actual->getOptions()[1]->getId());
        $this->assertEquals($option2->getValue(), $actual->getOptions()[1]->getValue());
        $this->assertEquals($option2->getDisabled(), $actual->getOptions()[1]->getDisabled());
    }
}
