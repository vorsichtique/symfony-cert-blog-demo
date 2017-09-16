<?php


namespace CertificationBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use CertificationBundle\Validator\Constraint as MaluAssert;

/**
 * @Assert\GroupSequence({"CustomConstraintExample", "malugroup", "maluSecondGroup"})
 */
class CustomConstraintExample
{

    /**
     * @MaluAssert\StartsWithColon
     */
    protected $title;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @Assert\Length(min=3, groups={"malugroup"})
     * @Assert\NotBlank(groups={"malugroup"})
     */
    protected $secondTitle;

    /**
     * @return mixed
     */
    public function getSecondTitle()
    {
        return $this->secondTitle;
    }

    /**
     * @param mixed $secondTitle
     */
    public function setSecondTitle($secondTitle)
    {
        $this->secondTitle = $secondTitle;
    }

    /**
     * @Assert\Length(min=3, groups={"maluSecondGroup"})
     * @Assert\NotBlank(groups={"maluSecondGroup"})
     */
    protected $thirdTitle;

    /**
     * @return mixed
     */
    public function getThirdTitle()
    {
        return $this->thirdTitle;
    }

    /**
     * @param mixed $thirdTitle
     */
    public function setThirdTitle($thirdTitle)
    {
        $this->thirdTitle = $thirdTitle;
    }



}