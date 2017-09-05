<?php


namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use AppBundle\Entity\BlogPost;
use AppBundle\Entity\Tag;

class PostAndTagsData extends AbstractFixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function load(ObjectManager $em)
    {
        $passwordEncoder = $this->container->get('security.password_encoder');

        $user1 = new User();
        $user1->setUsername('malu');
        $encodedPassword = $passwordEncoder->encodePassword($user1, 'kitten');
        $user1->setPassword($encodedPassword);
        $user1->setRoles(['ROLE_USER']);
        $em->persist($user1);

        $user2 = new User();
        $user2->setUsername('admin');
        $encodedPassword = $passwordEncoder->encodePassword($user2, 'kitten');
        $user2->setPassword($encodedPassword);
        $user2->setRoles(['ROLE_ADMIN']);
        $em->persist($user2);

        $em->flush();

        $tagStrings = ['aaaaaa', 'bbbbbb', 'cccmcc', 'ooooo'];
        $tags = [];

        foreach ($tagStrings as $tag) {
            $newTag = new Tag();
            $newTag->setLabel($tag);
            $tags[] = $newTag;
        }

        $i = 0;
        $titleOrg = file_get_contents('https://loripsum.net/api/1/plaintext');
        $titleOrg = strtolower($titleOrg);
        $titleOrg = preg_replace('/[^a-z\s]/', '', $titleOrg);

        $author = $em->getRepository(User::class)->find(1);

        while($i < 10) {
            $bp = new BlogPost();
            $title = explode(' ', $titleOrg);
            shuffle($title);
            $title = array_slice($title, 0, 7);
            $title = implode(' ', $title);
            $title = ucfirst($title);
            $bp->setTitle($title);
            $bp->setAuthor($author);
            $bp->setSlug(str_replace(' ', '-', strtolower($title)));

            $content = file_get_contents('https://loripsum.net/api/plaintext');
            $bp->setContent($content);
            $bp->setPublicationDate(new \DateTime());

            shuffle($tags);
            $bp->addTag($tags[0]);

            $em->persist($bp);

            $i++;
        }

        $em->flush();

    }

}