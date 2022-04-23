<?php namespace October\Test\Skins;

use Backend\Classes\Skin as SkinBase;

/**
 * BackendSkin
 */
class BackendSkin extends SkinBase
{
    /**
     * @inheritDoc
     */
    public function skinDetails()
    {
        return [
            'name' => 'Custom Skin'
        ];
    }
}
