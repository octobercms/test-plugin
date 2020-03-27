<?php namespace October\Test\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use October\Test\Models\Channel;

/**
 * Trees Back-end Controller
 */
class Trees extends Controller
{
	public $implement = [
		'Backend.Behaviors.ListController'
	];
	
	public $listConfig = [
		'members'    => 'config_members_list.yaml',
		'categories' => 'config_categories_list.yaml',
		'channels'   => 'config_channels_list.yaml'
	];
	
	public $requiredPermissions = ['october.test.access_plugin'];
	
	public function __construct()
	{
		parent::__construct();
		
		BackendMenu::setContext('October.Test', 'test', 'trees');
	}
	
	public function listExtendRecords($records, $definition)
	{
		if ( $definition === 'channels' ) {
			return Channel::whereIn('id', [11, 12])->get()->toNested(false);
		}
		
		return $records;
	}
}
