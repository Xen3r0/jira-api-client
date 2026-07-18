<?php

namespace Xen3r0\JiraApiClient\Serializer\Normalizer\Issue;

use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Xen3r0\Adf\Node\Block\Document;
use Xen3r0\JiraApiClient\Model\Issue\Worklog;

readonly class WorklogNormalizer implements NormalizerInterface, DenormalizerInterface
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
        return $data instanceof Worklog;
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Worklog::class === $type;
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
        if (!$object instanceof Worklog) {
            return null;
        }

        $data = $this->objectNormalizer->normalize(
            $object,
            $format,
            [
                ...$context,
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['comment'],
            ]
        );
        if (!is_array($data)) {
            return $data;
        }

        if ($object->getComment() instanceof Document) {
            $data['comment'] = $object->getComment()->jsonSerialize();
        }

        return $data;
    }

    /**
     * @param array<string, mixed> $context
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): ?Worklog
    {
        $basicFields = [];
        foreach ($data as $key => $value) {
            if ('comment' === $key) {
                continue;
            }

            $basicFields[$key] = $value;
        }

        $object = $this->objectNormalizer->denormalize($basicFields, $type, $format, $context);

        if (!$object instanceof Worklog) {
            return null;
        }

        if (isset($data['comment']) && is_array($data['comment'])) {
            $object->setComment(Document::load($data['comment']));
        }

        return $object;
    }
}
