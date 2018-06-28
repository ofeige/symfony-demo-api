<?php

namespace App\Dto;

/**
 * Class UserV3
 * @package App\Dto
 */
class UserV3
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $forename;

    /**
     * @var string
     */
    private $surname;

    /**
     * @var AddressV1[]
     */
    private $addresses = [];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserV3
     */
    public function setId(int $id): UserV3
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return UserV3
     */
    public function setUsername(string $username): UserV3
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UserV3
     */
    public function setEmail(string $email): UserV3
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getForename(): string
    {
        return $this->forename;
    }

    /**
     * @param string $forename
     * @return UserV3
     */
    public function setForename(string $forename): UserV3
    {
        $this->forename = $forename;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return UserV3
     */
    public function setSurname(string $surname): UserV3
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return AddressV1[]
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    /**
     * @param AddressV1[] $addresses
     * @return UserV3
     */
    public function setAddresses(array $addresses): UserV3
    {
        $this->addresses = $addresses;
        return $this;
    }

    /**
     * @param AddressV1 $address
     * @return UserV3
     */
    public function addAddress(AddressV1 $address): UserV3
    {
        $this->addresses[] = $address;
        return $this;
    }
}