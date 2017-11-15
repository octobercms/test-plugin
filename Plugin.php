<?php namespace October\Test;

use Backend;
use RainLab\User\Models\User as FrontUser;
use RainLab\User\Controllers\Users as UsersController;
use Illuminate\Support\Facades\DB;
use System\Classes\PluginBase;

/**
 * Test Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'October Tester',
            'description' => 'Used for testing the Relation Controller behavior and others.',
            'author'      => 'Alexey Bobkov, Samuel Georges',
            'icon'        => 'icon-child',
            'homepage'    => 'https://github.com/daftspunk/oc-test-plugin'
        ];
    }

    public function registerReportWidgets()
    {
        return [
            'October\Test\ReportWidgets\SolidGauge' => [
                'label'   => 'Solid Gauge',
                'context' => 'dashboard'
            ],
            'October\Test\ReportWidgets\SemiCircle' => [
                'label'   => 'Semi Circle',
                'context' => 'dashboard'
            ],
        ];
    }

    public function registerNavigation()
    {
        return [
            'test' => [
                'label'       => 'Playground',
                'url'         => Backend::url('october/test/people'),
                'icon'        => 'icon-child',
                'order'       => 100,

                'sideMenu' => [
                    'people' => [
                        'label'       => 'People',
                        'icon'        => 'icon-database',
                        'url'         => Backend::url('october/test/people'),
                    ],
                    'posts' => [
                        'label'       => 'Posts',
                        'icon'        => 'icon-database',
                        'url'         => Backend::url('october/test/posts'),
                    ],
                    'users' => [
                        'label'       => 'Users',
                        'icon'        => 'icon-database',
                        'url'         => Backend::url('october/test/users'),
                    ],
                    'countries' => [
                        'label'       => 'Countries',
                        'icon'        => 'icon-database',
                        'url'         => Backend::url('october/test/countries'),
                    ],
                    'reviews' => [
                        'label'       => 'Reviews',
                        'icon'        => 'icon-database',
                        'url'         => Backend::url('october/test/reviews'),
                    ],
                    'galleries' => [
                        'label'       => 'Galleries',
                        'icon'        => 'icon-database',
                        'url'         => Backend::url('october/test/galleries'),
                    ],
                    'trees' => [
                        'label'       => 'Trees',
                        'icon'        => 'icon-database',
                        'url'         => Backend::url('october/test/trees'),
                    ],
                ]
            ]
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'October\Test\FormWidgets\TimeChecker' => [
                'code'  => 'timecheckertest'
            ]
        ];
    }

    public function boot()
    {
        FrontUser::extend(function($model) {
            $model->belongsToMany['friends']=[
                'RainLab\User\Models\User',
                'table'    => 'october_test_friends',
                'pivot' => ['status'],
                'pivotModel' => 'October\Test\Models\FriendsPivot',
                'timestamps' => true,
                'key'      => 'user_id',
                'otherKey' => 'friend_id'
            ];

            // Do not show current user in the list of users that can be added as friend
            $model->addDynamicMethod('scopeNotThis', function ($query, $user) {
                return $query->where('id', '!=', $user->id);
            });

            $model->addDynamicMethod('isFriendWith', function (FrontUser $user) use ($model) {
                $isFriend = DB::table('october_test_friends')
                        ->whereUserId($model->id)
                        ->whereFriendId($user->id)
                        ->count() > 0;
                return $isFriend;
            });

            $model->addDynamicMethod('addFriend', function (FrontUser $user) use ($model) {
                $model->friends()->attach($user->id);
            });

            $model->addDynamicMethod('removeFriend', function (FrontUser $user) use ($model) {
                $model->friends()->detach($user->id);
            });

            $model->addDynamicMethod('getThumbAttribute', function() use ($model) {
                if($model->avatar)
                    return $model->avatar->path;
                return "";
            });

        });

        UsersController::extend(function($controller) {

            // Implement the RelationController behavior if not already implemented
            if (!in_array('Backend.Behaviors.RelationController', $controller->implement)) {
                $controller->implement[] = 'Backend.Behaviors.RelationController';
            }

            // Add the relationConfig property if not added already
            if (!isset($controller->relationConfig)) {
                $controller->addDynamicProperty('relationConfig');
            }

            // The new relation config file we want to merge
            $myConfigPath = '$/october/test/controllers/users/friends_relation.yaml';

            // Merge the above config with the existing one
            $controller->relationConfig = $controller->mergeConfig(
                $controller->relationConfig,
                $myConfigPath
            );
        });

        UsersController::extendFormFields(function($form, $model, $context) {
            if(!$model instanceof FrontUser or $context != 'preview'){
                // friends tab should not be displayed in update and create contexts
                return;
            }

            // Add a tab for list of friends in the User Controller page
            $form->addTabFields([
                'friends' => [
                    'label' => '',
                    'tab' => 'Friends',
                    'type' => 'partial',
                    'path' => '$/october/test/controllers/users/_friends.htm',
                ]
            ]);
        });
    }
}
