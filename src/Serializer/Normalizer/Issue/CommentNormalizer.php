<?php

namespace Xen3r0\JiraApiClient\Serializer\Normalizer\Issue;

use DH\Adf\Node\Block\Document;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Xen3r0\JiraApiClient\Model\Issue\Comment;

class CommentNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function __construct(
        private readonly ObjectNormalizer $objectNormalizer,
    ) {
    }

    public function supportsNormalization(mixed $data, ?string $format = null): bool
    {
        return $data instanceof Comment;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null): bool
    {
        return Comment::class === $type;
    }

    /**
     * @param array<string, mixed> $context
     *
     * @return array<string, mixed>|\ArrayObject<string, mixed>|bool|float|int|string|null
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array|\ArrayObject|bool|float|int|string|null
    {
        if (!$object instanceof Comment) {
            return null;
        }

        $data = $this->objectNormalizer->normalize(
            $object,
            $format,
            [
                ...$context,
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['body'],
            ]
        );
        if (!is_array($data)) {
            return $data;
        }

        if ($object->getBody() instanceof Document) {
            $data['description'] = $object->getBody()->jsonSerialize();
        }

        return $data;
    }

    /**
     * @param array<string, mixed> $context
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): ?Comment
    {
        $basicFields = [];
        foreach ($data as $key => $value) {
            if ('description' === $key) {
                continue;
            }

            $basicFields[$key] = $value;
        }

        $object = $this->objectNormalizer->denormalize($basicFields, $type, $format, $context);

        if (!$object instanceof Comment) {
            return null;
        }

        if (isset($data['body']) && is_array($data['body'])) {
            $document = Document::load($data['body']);
            if ($document instanceof Document) {
                $object->setBody($document);
            }
        }

        return $object;
    }
}
