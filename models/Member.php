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
     * @var string table associated with the model
     */
    public $table = 'october_test_members';

    /**
     * @var array propagatable attributes to copy to other sites
     */
    protected $propagatable = [];

    /**
     * @var bool|array propagatableSync keeps the record structure the same across all sites
     */
    protected $propagatableSync = true;

    /**
     * @var array belongsTo relations, where grand_parent is filled from the parent by filterFields
     */
    public $belongsTo = [
        'user' => \October\Test\Models\User::class,
        'grand_parent' => \October\Test\Models\Member::class
    ];

    /**
     * filterFields fills the grand parent from the parent's parent and copies the parent name into a form field when the form refreshes.
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
     * scopeEligibleParents excludes the model itself, its children and its current parent from the parent record finder.
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
