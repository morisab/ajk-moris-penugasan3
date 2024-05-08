<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Models\Cart\Cart;
use App\Core\Domain\Models\Cart\CartId;
use App\Core\Domain\Models\User\UserId;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlCartRepository
{
    public function persist(Cart $cart): void
    {
        DB::table('cart')->upsert([
            'id' => $cart->getId()->toString(),
            'user_id' => $cart->getUserId()->toString(),
            'volume_id' => $cart->getVolumeId(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(CartId $id): ?Cart
    {
        $row = DB::table('cart')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function findByVolumeId(int $volume_id): ?Cart
    {
        $row = DB::table('cart')->where('volume_id', $volume_id)->first();
        if (!$row) {
            return null;
        }
        return $this->constructFromRows([$row])[0];
    }

    public function findByVolumeIdAndUserId(int $volume_id, UserId $user_id): ?Cart
    {
        $row = DB::table('cart')->where('volume_id', $volume_id)->where('user_id', $user_id->toString())->first();
        if (!$row) {
            return null;
        }
        return $this->constructFromRows([$row])[0];
    }

    public function findByUserId(UserId $user_id): ?array
    {
        $rows = DB::table('cart')->where('user_id', $user_id->toString())->get();
        $cart = [];
        foreach ($rows as $row) {
            $cart[] = $this->constructFromRows([$row])[0];
        }
        return $cart;
    }

    public function delete(int $volume_id): void
    {
        DB::table('cart')->where('volume_id', $volume_id)->limit(1)->delete();
    }

    public function deleteByVolumeId(int $volume_id): void
    {
        DB::table('cart')->where('volume_id', $volume_id)->delete();
    }

    public function getCartVolumeByUserId(UserId $user_id): array
    {
        $rows = DB::table('cart')->where('user_id', $user_id->toString())->groupBy('volume_id')->get();
        $cart = [];
        foreach ($rows as $row) {
            $cart[] = $this->constructFromRows([$row])[0];
        }
        return $cart;
    }

    public function countJumlahSewa(string $volume_id, UserId $user_id): int
    {
        $rows = DB::table('cart')->where('user_id', $user_id->toString())->where('volume_id', $volume_id)->count();
        return $rows;
    }

    /**
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $cart = [];
        foreach ($rows as $row) {
            $cart[] = new Cart(
                new CartId($row->id),
                new UserId($row->user_id),
                $row->volume_id,
            );
        }
        return $cart;
    }
}
