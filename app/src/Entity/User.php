<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(
        message: '必ず入力してください'
    )]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(
        message: '必ず入力してください'
    )]
    private $lastName;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(
        message: '必ず入力してください'
    )]
    private $firstNameKana;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(
        message: '必ず入力してください'
    )]
    private $lastNameKana;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(
        message: '必ず入力してください'
    )]
    #[Assert\Email(
        message: 'メールアドレスは正しい形式で入力してください： {{ value }}',
    )]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(
        message: '必ず入力してください'
    )]
    #[Assert\Regex(
        pattern: '/^([a-zA-Z0-9]{8,})$/',
        message: '半角英数字8文字以上で入力してください',
    )]    
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstNameKana(): ?string
    {
        return $this->firstNameKana;
    }

    public function setFirstNameKana(string $firstNameKana): self
    {
        $this->firstNameKana = $firstNameKana;

        return $this;
    }

    public function getLastNameKana(): ?string
    {
        return $this->lastNameKana;
    }

    public function setLastNameKana(string $lastNameKana): self
    {
        $this->lastNameKana = $lastNameKana;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
