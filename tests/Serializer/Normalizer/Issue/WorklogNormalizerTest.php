<?php

namespace Xen3r0\JiraApiClient\Tests\Serializer\Normalizer\Issue;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Xen3r0\Adf\Node\Block\Document;
use Xen3r0\JiraApiClient\Model\Issue\Worklog;
use Xen3r0\JiraApiClient\Serializer\Normalizer\Issue\WorklogNormalizer;
use Xen3r0\JiraApiClient\Serializer\SerializerFactory;

class WorklogNormalizerTest extends TestCase
{
    private const ADF_COMMENT = [
        'type' => 'doc',
        'version' => 1,
        'content' => [
            [
                'type' => 'paragraph',
                'content' => [
                    ['type' => 'text', 'text' => 'Worked on the API integration'],
                ],
            ],
        ],
    ];

    public function testSupportsNormalization(): void
    {
        $normalizer = new WorklogNormalizer(new ObjectNormalizer());

        $this->assertTrue($normalizer->supportsNormalization(new Worklog()));
        $this->assertFalse($normalizer->supportsNormalization(new \stdClass()));
    }

    public function testSupportsDenormalization(): void
    {
        $normalizer = new WorklogNormalizer(new ObjectNormalizer());

        $this->assertTrue($normalizer->supportsDenormalization([], Worklog::class));
        $this->assertFalse($normalizer->supportsDenormalization([], \stdClass::class));
    }

    public function testGetSupportedTypes(): void
    {
        $normalizer = new WorklogNormalizer(new ObjectNormalizer());

        $this->assertSame(['object' => true], $normalizer->getSupportedTypes(null));
    }

    public function testNormalizeReturnsNullForNonWorklog(): void
    {
        $normalizer = new WorklogNormalizer(new ObjectNormalizer());

        $this->assertNull($normalizer->normalize(new \stdClass()));
    }

    public function testNormalizeSerializesDocumentComment(): void
    {
        $comment = Document::load(self::ADF_COMMENT);

        $worklog = (new Worklog())
            ->setId('10000')
            ->setComment($comment);

        $data = json_decode(SerializerFactory::create()->serialize($worklog, 'json'), true);

        $this->assertIsArray($data);
        $this->assertEquals(self::ADF_COMMENT, $data['comment']);
    }

    public function testDenormalizeBuildsDocumentFromCommentArray(): void
    {
        $content = json_encode(['id' => '10000', 'comment' => self::ADF_COMMENT]);
        $this->assertIsString($content);

        $worklog = SerializerFactory::create()->deserialize($content, Worklog::class, 'json');

        $this->assertInstanceOf(Worklog::class, $worklog);
        $this->assertEquals('10000', $worklog->getId());
        $this->assertInstanceOf(Document::class, $worklog->getComment());
        $this->assertEquals(self::ADF_COMMENT, json_decode((string) json_encode($worklog->getComment()), true));
    }

    public function testDenormalizeWithoutComment(): void
    {
        $worklog = SerializerFactory::create()->deserialize('{"id":"10000"}', Worklog::class, 'json');

        $this->assertInstanceOf(Worklog::class, $worklog);
        $this->assertNull($worklog->getComment());
    }
}
