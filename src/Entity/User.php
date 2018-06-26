<?php
namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class User
 * @package App\Entity
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User {
    const ACTIVE_YES = 'yes';
    const ACTIVE_NO = 'no';

    /**
     * @var int
     *
     * @Groups({"user"})
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Groups({"user"})
     *
     * @ORM\Column(name="user_username", type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var string
     *
     * @Groups({"user"})
     *
     * @ORM\Column(name="user_email", type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @Groups({"user"})
     *
     * @ORM\Column(name="user_forename", type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $forename;

    /**
     * @var string
     *
     * @Groups({"user"})
     *
     * @ORM\Column(name="user_surname", type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="user_password", type="string", length=255)
     */
    private $passwordHash;

    /**
     * @var string
     *
     * @ORM\Column(name="user_password_salt", type="string", length=255)
     */
    private $passwordSalt;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="8")
     * @Assert\Regex("/[a-z]/", message="This value should contain a lower case letter.")
     * @Assert\Regex("/[A-Z]/", message="This value should contain an upper case letter.")
     * @Assert\Regex("/[0-9]/", message="This value should contain a digit.")
     */
    private $plainPassword;

    /**
     * @var Address[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Address", mappedBy="user")
     */
    private $addresses = [];

    /**
     * @var string
     *
     * @Groups({"user"})
     *
     * @ORM\Column(name="user_active", type="string", length=255, columnDefinition="ENUM('yes','no')")
     *
     * @Assert\NotBlank()
     * @Assert\Choice({"yes","no"})
     */
    private $active;

    /**
     * @var \DateTime
     *
     * @Groups({"user"})
     *
     * @ORM\Column(name="user_created", type="datetime")
     */
    private $created;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
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
     * @return User
     */
    public function setUsername(string $username): User
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
     * @return User
     */
    public function setEmail(string $email): User
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
     * @return User
     */
    public function setForename(string $forename): User
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
     * @return User
     */
    public function setSurname(string $surname): User
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @param string $passwordHash
     * @return User
     */
    public function setPasswordHash(string $passwordHash): User
    {
        $this->passwordHash = $passwordHash;
        return $this;
    }

    /**
     * @return string
     */
    public function getPasswordSalt(): string
    {
        return $this->passwordSalt;
    }

    /**
     * @param string $passwordSalt
     * @return User
     */
    public function setPasswordSalt(string $passwordSalt): User
    {
        $this->passwordSalt = $passwordSalt;
        return $this;
    }

    /**
     * @return Address[]|Collection
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    /**
     * @param Address[]|Collection $addresses
     * @return User
     */
    public function setAddresses(Collection $addresses): User
    {
        $this->addresses = $addresses;
        return $this;
    }

    /**
     * @param Address $address
     * @return User
     */
    public function addAddress(Address $address): User
    {
        $this->addresses[] = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getActive(): string
    {
        return $this->active;
    }

    /**
     * @param string $active
     * @return User
     */
    public function setActive(string $active): User
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     * @return User
     */
    public function setCreated(\DateTime $created): User
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     * @return User
     */
    public function setPlainPassword(string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

}