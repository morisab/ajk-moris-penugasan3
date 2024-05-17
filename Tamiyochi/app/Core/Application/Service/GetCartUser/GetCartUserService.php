<?php

namespace App\Core\Application\Service\GetCartUser;

use Exception;
use App\Core\Domain\Models\User\UserId;
use App\Infrastructure\Repository\SqlCartRepository;
use App\Infrastructure\Repository\SqlSeriRepository;
use App\Infrastructure\Repository\SqlVolumeRepository;
use App\Core\Application\Service\GetCartUser\GetCartUserResponse;

class GetCartUserService
{
    private SqlCartRepository $cart_repository;
    private SqlVolumeRepository $volume_repository;
    private SqlSeriRepository $seri_repository;

    public function __construct(SqlCartRepository $cart_repository, SqlVolumeRepository $volume_repository, SqlSeriRepository $seri_repository)
    {
        $this->cart_repository = $cart_repository;
        $this->volume_repository = $volume_repository;
        $this->seri_repository = $seri_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $user_id)
    {
        $volume = $this->cart_repository->getCartVolumeByUserId(new UserId($user_id));

        $response = [];
        $total_pinjaman = 0;
        $total_harga_sewa = 0;
        foreach ($volume as $vol) {
            $list_volume = $this->volume_repository->find($vol->getVolumeId());
            $count_jumlah_sewa = $this->cart_repository->countJumlahSewa($vol->getVolumeId(), new UserId($user_id));
            $seri = $this->seri_repository->find($list_volume->getSeriId());
            $response[] = new GetCartUserResponse(
                $list_volume->getId(),
                $seri->getFoto(),
                $list_volume->getJumlahTersedia(),
                $count_jumlah_sewa,
                $list_volume->getHargaSewa(),
                $list_volume->getVolume(),
                $list_volume->getHargaSewa() * $count_jumlah_sewa,
                $seri->getJudul(),
            );
            $total_pinjaman += $count_jumlah_sewa;
            $total_harga_sewa += $list_volume->getHargaSewa() * $count_jumlah_sewa;
        }

        $response_json = [
            "cart" => $response,
            "total_pinjaman" => $total_pinjaman,
            "total_harga_sewa" => $total_harga_sewa
        ];

        return $response_json;
    }
}
