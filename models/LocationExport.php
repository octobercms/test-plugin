<?php namespace October\Test\Models;

use Backend\Models\ExportModel;

class LocationExport extends ExportModel
{
    public function exportData($columns, $sessionKey = null)
    {
        $locations = Location::all();

        $locations->each(function($location) use ($columns) {
            $location->addVisible($columns);
        });

        return $locations->toArray();
    }
}
