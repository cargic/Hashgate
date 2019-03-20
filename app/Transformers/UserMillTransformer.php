<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class UserMillTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param $resource
     * @return array
     */
    public function transform( $resource )
    {
        return [
            'user_id' => $resource->user_id,
            'mill_group_id' => $resource->mill_group_id,
            'mill_number' => $resource->mill_number,
            'vga_type' => $resource->vga_type,
            'vga_number' => $resource->vga_number,
            'ip' => $resource->ip,
            'power' => $resource->power,
            'status' => $resource->status,
            'anomaly_24hr' => $resource->anomaly_24hr,
            'online_24hr' => $resource->online_24hr,
            'remark' => $resource->remark,
        ];
    }
}
