<?php

namespace Xen3r0\JiraApiClient\Serializer\Normalizer\Issue;

use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Xen3r0\Adf\Node\Block\Document;
use Xen3r0\JiraApiClient\Model\Issue\Comment;

readonly class CommentNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function __construct(
        private ObjectNormalizer $objectNormalizer,
    ) {
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Comment;
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Comment::class === $type;
    }

    /**
     * @return array<string, bool>
     */
    public function getSupportedTypes(?string $format): array
    {
        return ['object' => __CLASS__ === static::class];
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
            $data['body'] = $object->getBody()->jsonSerialize();
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
            if ('body' === $key) {
                continue;
            }

            $basicFields[$key] = $value;
        }

        $object = $this->objectNormalizer->denormalize($basicFields, $type, $format, $context);

        if (!$object instanceof Comment) {
            return null;
        }

        if (isset($data['body']) && is_array($data['body'])) {
            $object->setBody(Document::load($data['body']));
        }

        return $object;
    }
}
