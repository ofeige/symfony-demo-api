<?php

namespace App\Dto;

/**
 * Class UserV1
 * @package App\Dto
 */
class UserV1
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserV1
     */
    public function setId(int $id): UserV1
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
     * @return UserV1
     */
    public function setUsername(string $username): UserV1
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
     * @return UserV1
     */
    public function setEmail(string $email): UserV1
    {
        $this->email = $email;
        return $this;
    }
}