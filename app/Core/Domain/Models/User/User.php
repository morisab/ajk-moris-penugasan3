<?php

namespace App\Core\Domain\Models\User;

use App\Core\Domain\Models\Cart\Cart;
use Exception;
use App\Core\Domain\Models\Email;
use App\Core\Domain\Models\Peminjaman\Peminjaman;
use Illuminate\Support\Facades\Hash;
use App\Core\Domain\Models\User\UserId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    private UserId $id;
    private int $kabupaten_id;
    private string $name;
    private Email $email;
    private string $no_telp;
    private UserType $user_type;
    private int $age;
    private string $image_url;
    private string $hashed_password;

    /**
     * @param UserId $id
     * @param int $kabupaten_id
     * @param string $name
     * @param Email $email
     * @param string $no_telp
     * @param UserType $user_type
     * @param int $age
     * @param string $image_url
     * @param string $hashed_password
     */
    public function __construct(UserId $id, int $kabupaten_id, string $name, Email $email, string $no_telp, UserType $user_type, int $age, string $image_url, string $hashed_password)
    {
        $this->id = $id;
        $this->kabupaten_id = $kabupaten_id;
        $this->name = $name;
        $this->email = $email;
        $this->no_telp = $no_telp;
        $this->user_type = $user_type;
        $this->age = $age;
        $this->image_url = $image_url;
        $this->hashed_password = $hashed_password;
    }
    
    /**
     * @throws Exception
     */
    public static function create(int $kabupaten_id, string $name, Email $email, string $no_telp, UserType $user_type, int $age, string $image_url, string $hashed_password): self
    {
        return new self(
            UserId::generate(),
            $kabupaten_id,
            $name,
            $email,
            $no_telp,
            $user_type,
            $age,
            $image_url,
            Hash::make($hashed_password)
        );
    }

    /**
     * @return UserId
     */
    public function getId(): UserId
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getKabupatenId(): int
    {
        return $this->kabupaten_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
    * @return Email
    */
    public function getEmail(): Email
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
     * @return UserType
     */
    public function getUserType(): UserType
    {
        return $this->user_type;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    /**
     * @return string
     */
    public function getHashedPassword(): string
    {
        return $this->hashed_password;
    }
    
    public function cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }

}
