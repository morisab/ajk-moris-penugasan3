<?php

namespace App\Core\Application\Service\RegisterUser;

use Illuminate\Http\UploadedFile;

class RegisterUserRequest
{
    private string $name;
    private string $email;
    private string $no_telp;
    private int $age;
    private UploadedFile $image;
    private string $password;

    /**
     * @param string $name
     * @param string $email
     * @param string $no_telp
     * @param int $age
     * @param UploadedFile $image
     * @param string $password
     */
    public function __construct(string $name, string $email, string $no_telp, int $age, UploadedFile $image, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->no_telp = $no_telp;
        $this->age = $age;
        $this->image = $image;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getNoTelp(): string
    {
        return $this->no_telp;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @return UploadedFile
     */
    public function getImage(): UploadedFile
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
