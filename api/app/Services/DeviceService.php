<?php


namespace App\Services;


use App\Repositories\DeviceRepository;

class DeviceService
{
    protected $deviceRepository;

    /**
     * @param DeviceRepository $deviceRepository
     */
    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }

    /**
     * Device register
     *
     * @param array $data
     * @return mixed
     */
    public function register(array $data)
    {
        return $this->deviceRepository->firstOrCreate($data);
    }
}
