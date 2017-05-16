<?php namespace October\Test\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Routing\Route;


class UsersController extends Controller
{
	public function index(Route $route){
		return [['username' => 'test'],['username' => 'otheruser']];
	}
}
?>