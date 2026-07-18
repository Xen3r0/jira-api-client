<?php

namespace Xen3r0\JiraApiClient\Tests\Serializer\Normalizer\Issue;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Xen3r0\Adf\Node\Block\Document;
use Xen3r0\JiraApiClient\Model\Issue\Comment;
use Xen3r0\JiraApiClient\Serializer\Normalizer\Issue\CommentNormalizer;
use Xen3r0\JiraApiClient\Serializer\SerializerFactory;

class CommentNormalizerTest extends TestCase
{
    private const ADF_BODY = [
        'type' => 'doc',
        'version' => 1,
        'content' => [
            [
                'type' => 'paragraph',
                'content' => [
                    ['type' => 'text', 'text' => 'Hello world'],
                ],
            ],
        ],
    ];

    public function testSupportsNormalization(): void
    {
        $normalizer = new CommentNormalizer(new ObjectNormalizer());

        $this->assertTrue($normalizer->supportsNormalization(new Comment()));
        $this->assertFalse($normalizer->supportsNormalization(new \stdClass()));
    }

    public function testSupportsDenormalization(): void
    {
        $normalizer = new CommentNormalizer(new ObjectNormalizer());

        $this->assertTrue($normalizer->supportsDenormalization([], Comment::class));
        $this->assertFalse($normalizer->supportsDenormalization([], \stdClass::class));
    }

    public function testGetSupportedTypes(): void
    {
        $normalizer = new CommentNormalizer(new ObjectNormalizer());

        $this->assertSame(['object' => true], $normalizer->getSupportedTypes(null));
    }

    public function testNormalizeReturnsNullForNonComment(): void
    {
        $normalizer = new CommentNormalizer(new ObjectNormalizer());

        $this->assertNull($normalizer->normalize(new \stdClass()));
    }

    public function testNormalizeSerializesDocumentBody(): void
    {
        $body = Document::load(self::ADF_BODY);

        $comment = (new Comment())
            ->setId('10000')
            ->setBody($body);

        $data = json_decode(SerializerFactory::create()->serialize($comment, 'json'), true);

        $this->assertIsArray($data);
        $this->assertEquals(self::ADF_BODY, $data['body']);
    }

    public function testDenormalizeBuildsDocumentFromBodyArray(): void
    {
        $content = json_encode(['id' => '10000', 'body' => self::ADF_BODY]);
        $this->assertIsString($content);

        $comment = SerializerFactory::create()->deserialize($content, Comment::class, 'json');

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertEquals('10000', $comment->getId());
        $this->assertInstanceOf(Document::class, $comment->getBody());
        $this->assertEquals(self::ADF_BODY, json_decode((string) json_encode($comment->getBody()), true));
    }

    public function testDenormalizeWithoutBody(): void
    {
        $comment = SerializerFactory::create()->deserialize('{"id":"10000"}', Comment::class, 'json');

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertNull($comment->getBody());
    }
}
