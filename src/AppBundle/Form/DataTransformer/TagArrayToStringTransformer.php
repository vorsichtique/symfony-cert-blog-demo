<?php


namespace AppBundle\Form\DataTransformer;


use AppBundle\Entity\Tag;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;

class TagArrayToStringTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function transform($array)
    {
        return implode(',', $array);
    }

    public function reverseTransform($string)
    {
        if ('' === $string || null === $string) {
            return [];
        }

        $labels = array_filter(array_unique(array_map('trim', explode(',', $string))));

        // Get the current tags and find the new ones that should be created.
        $tags = $this->manager->getRepository(Tag::class)->findBy([
            'label' => $labels,
        ]);
        $newLabels = array_diff($labels, $tags);
        foreach ($newLabels as $label) {
            $tag = new Tag();
            $tag->setLabel($label);
            $tags[] = $tag;

            // There's no need to persist these new tags because Doctrine does that automatically
            // thanks to the cascade={"persist"} option in the AppBundle\Entity\Post::$tags property.
        }

        // Return an array of tags to transform them back into a Doctrine Collection.
        // See Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer::reverseTransform()
        return $tags;
    }
}