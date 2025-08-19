<?php

namespace Xen3r0\JiraApiClient\Serializer\Normalizer\Issue;

use DH\Adf\Node\Block\Document;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Xen3r0\JiraApiClient\Model\Issue\CustomField;
use Xen3r0\JiraApiClient\Model\Issue\Fields;

class FieldsNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function __construct(
        private readonly ObjectNormalizer $objectNormalizer,
    ) {
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Fields;
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Fields::class === $type;
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
        if (!$object instanceof Fields) {
            return null;
        }

        $data = $this->objectNormalizer->normalize(
            $object,
            $format,
            [
                ...$context,
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['description', 'customFields'],
            ]
        );
        if (!is_array($data)) {
            return $data;
        }

        if ($object->getDescription() instanceof Document) {
            $data['description'] = $object->getDescription()->jsonSerialize();
        }

        foreach ($object->getCustomFields() as $name => $value) {
            $data[$name] = $this->objectNormalizer->normalize($value, $format, $context);
        }

        return $data;
    }

    /**
     * @param array<string, mixed> $context
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): ?Fields
    {
        $basicFields = [];
        foreach ($data as $key => $value) {
            if (str_starts_with($key, 'customfield_')) {
                continue;
            }

            if ('description' === $key) {
                continue;
            }

            $basicFields[$key] = $value;
        }

        $object = $this->objectNormalizer->denormalize($basicFields, $type, $format, $context);

        if (!$object instanceof Fields) {
            return null;
        }

        foreach ($data as $name => $value) {
            if (str_starts_with($name, 'customfield_')) {
                if (isset($value['id'])) {
                    $customField = (new CustomField())
                        ->setId($value['id'] ?? null)
                        ->setValue($value['value'] ?? null)
                        ->setSelf($value['self'] ?? null);
                    $object->setCustomField($name, $customField);
                }
            }
        }

        if (isset($data['description']) && is_array($data['description'])) {
            $document = Document::load($data['description']);
            if ($document instanceof Document) {
                $object->setDescription($document);
            }
        }

        return $object;
    }
}
