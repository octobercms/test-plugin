<?php

namespace October\Test\Updates;

use October\Test\Models\Tests;
use October\Rain\Database\Updates\Seeder;

class SeedOctoberTestsTable extends Seeder
{

    /**
     * @return void
     */
    public function run()
    {
        Tests::create([

            /* Grid fields */

            'grid1'  => 'Width 100%',
            'grid2'  => 'Width 50%',
            'grid3'  => 'Width 50%',
            'grid4'  => 'Width 50%',
            'grid5'  => 'Width 50%',
            'grid6'  => 'Width 25%',
            'grid7'  => 'Width 25%',
            'grid8'  => 'Width 25%',
            'grid9'  => 'Width 25%',
            'grid10' => 'Width 33.3%',
            'grid11' => 'Width 33.3%',
            'grid12' => 'Width 33.3%',
            'grid13' => 'Width 66.6%',
            'grid14' => 'Width 33.3%',
            'grid15' => 'Width 33.3%',
            'grid16' => 'Width 66.6%',
            'grid17' => 'Width 75%',
            'grid18' => 'Width 25%',
            'grid19' => 'Width 25%',
            'grid20' => 'Width 75%',
            'grid21' => 'Width 100%',

            /* New line fields */

            'newline1'  => 'New line added',
            'newline2'  => 'New line added',
            'newline3'  => 'New line added',
            'newline4'  => 'New line added',
            'newline5'  => 'No new line added',

            /* Grow and stretch fields */

            'grow1'    => 'This textarea has a fixed height',
            'grow2'    => 'This textarea has a dynamic height',
            'grow3'    => 'This markdown editor has a fixed height',
            'grow4'    => 'This markdown editor has a dynamic height',
            'grow5'    => 'This code editor has a fixed height',
            'grow6'    => 'This code editor has a dynamic height',
            'grow7'    => 'This rich editor has a fixed height',
            'grow8'    => 'This rich editor has a dynamic height',
            'stretch1' => 'This textarea has a fixed height set by size = small',
            'stretch2' => 'This textarea has been stretched to fill the rest of the form area, we recommend setting the last field to stretch',
            'stretch3' => 'This rich editor has a fixed height set by size = small',
            'stretch4' => 'This rich editor has been stretched to fill the rest of the form area, we recommend setting the last field to stretch',
            'stretch5' => 'This markdown editor has a fixed height set by size = small',
            'stretch6' => 'This markdown has been stretched to fill the rest of the form area, we recommend setting the last field to stretch',
            'stretch7' => 'This code editor has a fixed height set by size = small',
            'stretch8' => 'This code editor has been stretched to fill the rest of the form area, we recommend setting the last field to stretch',

        ]);
    }

}