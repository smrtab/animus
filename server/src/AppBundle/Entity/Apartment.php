<?php

namespace AppBundle\Entity;

/**
 * Apartment
 */
class Apartment
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $move_in_date;

    /**
     * @var string
     */
    private $street;

    /**
     * @var int
     */
    private $postCode;

    /**
     * @var string
     */
    private $town;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $email;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set moveInDate
     *
     * @param \DateTime $moveInDate
     *
     * @return Apartment
     */
    public function setMoveInDate($moveInDate)
    {
        $this->move_in_date = $moveInDate;

        return $this;
    }

    /**
     * Get moveInDate
     *
     * @return \DateTime
     */
    public function getMoveInDate()
    {
        return $this->move_in_date;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Apartment
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set postCode
     *
     * @param integer $postCode
     *
     * @return Apartment
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * Get postCode
     *
     * @return int
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Set town
     *
     * @param string $town
     *
     * @return Apartment
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Apartment
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Apartment
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
