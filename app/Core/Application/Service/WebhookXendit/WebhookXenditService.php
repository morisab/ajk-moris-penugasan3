<?php

namespace App\Core\Application\Service\WebhookXendit;

use Exception;
use Xendit\Configuration;
use App\Core\Domain\Models\Peminjaman\PeminjamanId;
use App\Infrastructure\Repository\SqlCartRepository;
use App\Infrastructure\Repository\SqlPeminjamanRepository;
use App\Core\Domain\Models\PeminjamanVolume\PeminjamanVolume;
use App\Infrastructure\Repository\SqlPeminjamanVolumeRepository;
use App\Infrastructure\Repository\SqlVolumeRepository;

class WebhookXenditService
{
    private SqlPeminjamanRepository $peminjaman_repository;
    private SqlPeminjamanVolumeRepository $peminjaman_volume_repository;
    private SqlCartRepository $cart_repository;
    private SqlVolumeRepository $volume_repository;

    public function __construct(SqlPeminjamanRepository $peminjaman_repository, SqlPeminjamanVolumeRepository $peminjaman_volume_repository, SqlCartRepository $cart_repository, SqlVolumeRepository $volume_repository)
    {
        Configuration::setXenditKey(env('XENDIT_API_KEY', ""));
        $this->peminjaman_repository = $peminjaman_repository;
        $this->peminjaman_volume_repository = $peminjaman_volume_repository;
        $this->cart_repository = $cart_repository;
        $this->volume_repository = $volume_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $id)
    {
        $peminjaman = $this->peminjaman_repository->find(new PeminjamanId($id));

        $peminjaman->setStatus('SUCCESS');
        $this->peminjaman_repository->persist($peminjaman);

        $carts = $this->cart_repository->findByUserId($peminjaman->getUserId());
        foreach ($carts as $cart) {
            $peminjaman_volume = PeminjamanVolume::create(
                $peminjaman->getId(),
                $cart->getVolumeId(),
            );
            $this->peminjaman_volume_repository->persist($peminjaman_volume);
            $this->volume_repository->decrementJumlahTersedia($peminjaman_volume->getVolumeId());
            $this->cart_repository->delete($cart->getVolumeId());
        }
    }
}
