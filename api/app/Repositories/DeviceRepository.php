<?php


namespace App\Repositories;


use App\Models\Device;

class DeviceRepository
{
    private $device;

    public function __construct(Device $device)
    {
        $this->device = $device;
    }

    public function firstOrCreate(array $data)
    {
        return $this->device->firstOrCreate(
            [
                'u_id' => $data['u_id'],
                'app_id' => $data['app_id'],
            ],
            [
                'language' => $data['language'],
                'operating_system' => $data['operating_system']
            ]
        );
    }
}
