<?php namespace October\Test\Tests\Functional;

use PluginTestCase;
use Illuminate\Support\Facades\Log;
use October\Rain\Support\Facades\Config;

class RestApiTest extends PluginTestCase
{
    /*
     * I use valet for my plugins and this is the
     * plugin development project. feel free to
     * change this to whatever your route is. 
     */
    protected $baseUrl = 'http://testsuite.dev';


    /** @test */
    public function users_api_can_return_ok_response(){
        $this->call('GET','/api/users');
        $this->assertResponseOk();
    }

    /** @test */
    public function try_to_hit_action_route(){
        $response = $this->action(
            'GET',
            'October\Test\Http\Controllers\UsersController@index',
            [],
            []
        );
        $response_json = json_decode($response->getContent(), true);
        $this->assertTrue((bool)$response_json);
    }
    /** @test */
    public function can_hit_page_from_theme(){
        $this->visit('/')
            ->see('demo');
    }
}