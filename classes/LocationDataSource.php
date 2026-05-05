<?php namespace October\Test\Classes;

use Dashboard\Classes\ReportMetric;
use Dashboard\Classes\ReportDimension;
use Dashboard\Classes\ReportDataSourceBase;
use Dashboard\Classes\ReportFetchData;
use Dashboard\Classes\ReportFetchDataResult;
use Dashboard\Classes\ReportQueryBuilder;

/**
 * LocationDataSource providing information about test plugin locations.
 */
class LocationDataSource extends ReportDataSourceBase
{
    const DIMENSION_COUNTRY = 'country';
    const DIMENSION_CITY = 'city';

    const METRIC_COUNT = 'count';

    /**
     * __construct the data source
     */
    public function __construct()
    {
        $this->registerDimension(new ReportDimension(
            self::DIMENSION_COUNTRY,
            'october_test_countries.id',
            'Country',
            'october_test_countries.name'
        ));

        $this->registerDimension(new ReportDimension(
            self::DIMENSION_CITY,
            'october_test_cities.id',
            'City',
            'october_test_cities.name'
        ));

        $this->registerMetric(new ReportMetric(
            self::METRIC_COUNT,
            'october_test_locations.id',
            'Location Count',
            ReportMetric::AGGREGATE_COUNT
        ));
    }

    /**
     * fetchData
     */
    protected function fetchData(ReportFetchData $data): ReportFetchDataResult
    {
        $data = ReportQueryBuilder::fromFetchData($data, 'october_test_locations')
            ->onConfigureMetrics(function($query, $dimension, $metrics) {
                $query->leftJoin('october_test_cities', 'october_test_cities.id', '=', 'october_test_locations.city_id')
                    ->leftJoin('october_test_countries', 'october_test_countries.id', '=', 'october_test_locations.country_id');
            })
            ->get($data->metricsConfiguration);

        return $data;
    }
}
