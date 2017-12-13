<?php

namespace AppBundle\Entity;

use Ramsey\Uuid\Uuid;

/**
 * ApartmentToken
 */
class ApartmentToken
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $apartmentId;

    /**
     * @var string
     */
    private $token;


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
     * Set apartmentId
     *
     * @param integer $apartmentId
     *
     * @return ApartmentToken
     */
    public function setApartmentId($apartmentId)
    {
        $this->apartmentId = $apartmentId;

        return $this;
    }

    /**
     * Get apartmentId
     *
     * @return int
     */
    public function getApartmentId()
    {
        return $this->apartmentId;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return ApartmentToken
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    public function createFor($id, $manager) {

    	$token = Uuid::uuid4();

	    $this->setApartmentId($id);
	    $this->setToken($token);

	    $manager->persist($this);
	    $manager->flush();

	    return $this;
    }
}

