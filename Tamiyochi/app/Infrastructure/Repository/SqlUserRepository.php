<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Models\Email;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\User\UserType;
use App\Core\Domain\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlUserRepository implements UserRepositoryInterface
{
    public function persist(User $users): void
    {
        DB::table('users')->upsert([
            'id' => $users->getId()->toString(),
            'kabupaten_id' => $users->getKabupatenId(),
            'name' => $users->getName(),
            'email' => $users->getEmail()->toString(),
            'no_telp' => $users->getNoTelp(),
            'user_type' => $users->getUserType()->value,
            'age' => $users->getAge(),
            'image_url' => $users->getImageUrl(),
            'password' => $users->getHashedPassword(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(UserId $id): ?User
    {
        $row = DB::table('users')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    public function findByEmail(string $email): ?User
    {
        $row = DB::table('users')->where('email', $email)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    public function getAll(): ?array
    {
        $row = DB::table('users')->get();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows($row->all());
    }

    /**
     * @throws Exception
     */
    public function getAllWithSearch(string $search): ?array
    {
        $row = DB::table('users')->where('name', 'like', '%' . $search . '%')->get();
        
        if (!$row) {
            return null;
        }

        return $this->constructFromRows($row->all());
    }

    
    /**
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $users = [];
        foreach ($rows as $row) {
            $users[] = new User(
                new UserId($row->id),
                $row->kabupaten_id,
                $row->name,
                new Email($row->email),
                $row->no_telp,
                UserType::from($row->user_type),
                $row->age,
                $row->image_url,
                $row->password
            );
        }
        return $users;
    }
}
