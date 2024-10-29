<?php namespace October\Test\Models;

use Model;

/**
 * Member Model
 */
class Member extends Model
{
    use \October\Rain\Database\Traits\SimpleTree;
    use \October\Rain\Database\Traits\Multisite;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_members';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable fields
     */
    protected $fillable = [];

    /**
     * @var array propagatable list of attributes to propagate to other sites.
     */
    protected $propagatable = [];

    /**
     * @var bool|array propagatableSync will enforce model structures between all sites.
     */
    protected $propagatableSync = true;

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'user' => \October\Test\Models\User::class,
        'grand_parent' => \October\Test\Models\Member::class
    ];

    /**
     * filterFields
     */
    public function filterFields($fields, $context = null)
    {
        if ($fields->grand_parent && $this->parent?->parent) {
            $fields->grand_parent->value = $this->parent->parent->id;
        }

        // Simple context scope
        if (!isset($fields->parent_name)) {
            return;
        }

        // Only apply value when refreshing
        if ($context === 'refresh' && $this->parent) {
            $fields->parent_name->value = $this->parent->name;
        }
    }

    /**
     * scopeEligibleParents limits results to only records that are eligible to be parents of the
     * provided model. Ineligible parents include: The provided model itself, models with the
     * provided model as it's own parent already, and a model that is already the current
     * model's parent
     */
    public function scopeEligibleParents($query, $model)
    {
        $query
            ->where('id', '<>', $model->id)
            ->where(function($query) use ($model) {
                $query
                    ->where('parent_id', '!=', $model->id)
                    ->orWhereNull('parent_id')
                ;
            })
        ;

        if ($model->parent_id) {
            $query->where('id', '<>', $model->parent_id);
        }

        return $query;
    }
}
