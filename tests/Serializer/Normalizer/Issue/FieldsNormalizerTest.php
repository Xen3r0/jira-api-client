<?php

namespace Xen3r0\JiraApiClient\Tests\Serializer\Normalizer\Issue;

use DH\Adf\Node\Block\Document;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Xen3r0\JiraApiClient\Model\Issue\CustomField;
use Xen3r0\JiraApiClient\Model\Issue\Fields;
use Xen3r0\JiraApiClient\Serializer\Normalizer\Issue\FieldsNormalizer;
use Xen3r0\JiraApiClient\Serializer\SerializerFactory;

class FieldsNormalizerTest extends TestCase
{
    private const ADF_DESCRIPTION = [
        'type' => 'doc',
        'version' => 1,
        'content' => [
            [
                'type' => 'paragraph',
                'content' => [
                    ['type' => 'text', 'text' => 'Description'],
                ],
            ],
        ],
    ];

    public function testSupportsNormalization(): void
    {
        $normalizer = new FieldsNormalizer(new ObjectNormalizer());

        $this->assertTrue($normalizer->supportsNormalization(new Fields()));
        $this->assertFalse($normalizer->supportsNormalization(new \stdClass()));
    }

    public function testSupportsDenormalization(): void
    {
        $normalizer = new FieldsNormalizer(new ObjectNormalizer());

        $this->assertTrue($normalizer->supportsDenormalization([], Fields::class));
        $this->assertFalse($normalizer->supportsDenormalization([], \stdClass::class));
    }

    public function testGetSupportedTypes(): void
    {
        $normalizer = new FieldsNormalizer(new ObjectNormalizer());

        $this->assertSame(['object' => true], $normalizer->getSupportedTypes(null));
    }

    public function testNormalizeReturnsNullForNonFields(): void
    {
        $normalizer = new FieldsNormalizer(new ObjectNormalizer());

        $this->assertNull($normalizer->normalize(new \stdClass()));
    }

    public function testNormalizeSerializesDescriptionAndCustomFields(): void
    {
        $customField = (new CustomField())
            ->setId('customfield_10000')
            ->setValue('foo')
            ->setSelf('https://example.atlassian.net/rest/api/3/customField/10000');

        $description = Document::load(self::ADF_DESCRIPTION);
        $this->assertInstanceOf(Document::class, $description);

        $fields = (new Fields())
            ->setSummary('This is a bug')
            ->setDescription($description)
            ->setCustomFields(['customfield_10000' => $customField]);

        $data = json_decode(SerializerFactory::create()->serialize($fields, 'json'), true);

        $this->assertIsArray($data);
        $this->assertEquals('This is a bug', $data['summary']);
        $this->assertEquals(self::ADF_DESCRIPTION, $data['description']);
        $this->assertEquals('customfield_10000', $data['customfield_10000']['id']);
        $this->assertEquals('foo', $data['customfield_10000']['value']);
    }

    public function testDenormalizeBuildsDescriptionAndCustomFieldsFromRawData(): void
    {
        $content = json_encode([
            'summary' => 'This is a bug',
            'description' => self::ADF_DESCRIPTION,
            'customfield_10000' => [
                'id' => 'customfield_10000',
                'value' => 'foo',
                'self' => 'https://example.atlassian.net/rest/api/3/customField/10000',
            ],
        ]);
        $this->assertIsString($content);

        $fields = SerializerFactory::create()->deserialize($content, Fields::class, 'json');

        $this->assertInstanceOf(Fields::class, $fields);
        $this->assertEquals('This is a bug', $fields->getSummary());
        $this->assertInstanceOf(Document::class, $fields->getDescription());
        $this->assertEquals(self::ADF_DESCRIPTION, json_decode((string) json_encode($fields->getDescription()), true));

        $customField = $fields->getCustomFields()['customfield_10000'];
        $this->assertInstanceOf(CustomField::class, $customField);
        $this->assertEquals('customfield_10000', $customField->getId());
        $this->assertEquals('foo', $customField->getValue());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/customField/10000', $customField->getSelf());
    }

    public function testDenormalizeSkipsCustomFieldWithoutId(): void
    {
        $fields = SerializerFactory::create()->deserialize(
            '{"summary":"This is a bug","customfield_10000":null}',
            Fields::class,
            'json'
        );

        $this->assertInstanceOf(Fields::class, $fields);
        $this->assertEmpty($fields->getCustomFields());
    }

    public function testDenormalizeWithoutDescriptionOrCustomFields(): void
    {
        $fields = SerializerFactory::create()->deserialize('{"summary":"This is a bug"}', Fields::class, 'json');

        $this->assertInstanceOf(Fields::class, $fields);
        $this->assertNull($fields->getDescription());
        $this->assertEmpty($fields->getCustomFields());
    }
}
