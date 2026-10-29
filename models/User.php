<?php namespace October\Test\Models;

use Model;

/**
 * User Model
 */
class User extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_users';

    /**
     * @var array fillable attributes that can be mass assigned
     */
    protected $fillable = ['username'];

    /**
     * @var array jsonable attributes stored as JSON
     */
    protected $jsonable = [
        'media_files',
        'media_images',
    ];

    /**
     * @var array rules for validation, where photo, portfolio and roles validate relations
     */
    public $rules = [
        'username' => 'required',
        'photo' => 'required',
        'portfolio' => 'required',
        'roles' => 'required',
    ];

    /**
     * @var array customMessages for validation, where a rule message applies to every attribute
     */
    public $customMessages = [
        'required' => 'The :attribute field is WOW required.',
        'photo.required' => 'The :attribute field is required PHOTO.',
    ];

    /**
     * beforeValidate sets a validation.custom language key to test the fallback message, real code should use $customMessages instead.
     */
    public function beforeValidate()
    {
        \Lang::set('validation.custom.username.required', 'Say hello (Username field required)');
    }

    /**
     * @var array belongsTo relations
     */
    public $belongsTo = [
        'country' => Country::class
    ];

    /**
     * @var array hasMany relations
     */
    public $hasMany = [
        'posts' => Post::class
    ];

    /**
     * @var array belongsToMany relations, defining the same table three ways: plain, with pivot data and with a pivot model
     */
    public $belongsToMany = [
        'roles' => [
            Role::class,
            'table' => 'october_test_users_roles',
            'timestamps' => true,
            'order' => 'name'
        ],
        'roles_pivot' => [
            Role::class,
            'table' => 'october_test_users_roles',
            'pivot' => ['clearance_level', 'is_executive'],
            'timestamps' => true
        ],
        'roles_pivot_model' => [
            Role::class,
            'table' => 'october_test_users_roles',
            'pivot' => ['clearance_level', 'is_executive', 'country_id', 'evolution', 'salary'],
            'pivotKey' => 'id',
            'pivotModel' => UserRolePivot::class,
            'timestamps' => true,
        ],
    ];

    /**
     * @var array attachOne relations, using public, protected and custom file models
     */
    public $attachOne = [
        'photo' => \System\Models\File::class,
        'photo_secure' => [\System\Models\File::class, 'public' => false],
        'certificate' => [\System\Models\File::class],
        'certificate_secure' => [\System\Models\File::class, 'public' => false],
        'custom_file' => CustomFile::class
    ];

    /**
     * @var array attachMany relations
     */
    public $attachMany = [
        // Testing translated file titles and descriptions in a multi-file upload
        'portfolio' => \System\Models\TranslatableFile::class,
        'portfolio_secure' => [\System\Models\File::class, 'public' => false],
        'files' => [\System\Models\File::class],
        'files_secure' => [\System\Models\File::class, 'public' => false],
    ];

    /**
     * __construct binds local relation events, writing to the trace log when records are attached or detached.
     */
    public function __construct(...$args)
    {
        parent::__construct(...$args);

        $this->bindEvent('model.relation.detach', function ($relationName, $ids) {
            traceLog("Relation {$relationName} was removed", (array) $ids);
        });

        $this->bindEvent('model.relation.attach', function ($relationName, $ids, $attributes) {
            traceLog("New relation {$relationName} was created", $ids, $attributes);
        });
    }

    /**
     * filterScopes hides the roles filter when the disable roles checkbox is checked.
     */
    public function filterScopes($scopes)
    {
        if ($scopes->disable_roles->value) {
            $scopes->roles->hidden(true);
        }
    }

    /**
     * scopeApplyRoleFilter includes or excludes users with the selected roles, depending on the match mode of the roles filter.
     */
    public function scopeApplyRoleFilter($query, $scope)
    {
        $action = $scope->mode === 'exclude' ? 'whereDoesntHave' : 'whereHas';

        return $query->{$action}('roles', function($q) use ($scope) {
            $q->whereIn('october_test_roles.id', $scope->value);
        });
    }

    /**
     * getUserAndCode returns the username with the security code, serving kSink.testUser.userAndCode on the test theme's component page.
     */
    public function getUserAndCode()
    {
        return "{$this->username} ({$this->security_code})";
    }
}
