<?php namespace October\Test\Models;

use Model;

/**
 * RepeaterItem
 */
class RepeaterItem extends Model
{
    /**
     * @var string table used by the model.
     */
    public $table = 'october_test_repeater_items';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Jsonable fields
     */
    protected $jsonable = ['value'];

    /**
     * @var array fieldValues
     */
    protected $fieldValues = [];

    /**
     * @var array attachMany
     */
    public $attachMany = [
        'photos' => \System\Models\File::class,
    ];

    /**
     * afterFetch
     */
    protected function afterFetch()
    {
        $this->fieldValues = $this->value ?: [];
        $this->attributes = array_merge($this->fieldValues, $this->attributes);
    }

    /**
     * beforeSave
     */
    protected function beforeSave()
    {
        if ($this->fieldValues) {
            $this->value = $this->fieldValues;
        }
    }

    /**
     * saveInternal
     */
    protected function saveInternal($options = [])
    {
        // Purge the field values from the attributes
        $this->attributes = array_diff_key($this->attributes, $this->fieldValues);

        return parent::saveInternal($options);
    }

    /**
     * setAttribute
     */
    public function setAttribute($key, $value)
    {
        $result = parent::setAttribute($key, $value);

        if (!$this->isKeyAllowed($key)) {
            $this->fieldValues[$key] = $value;
        }

        return $result;

    }

    /**
     * isKeyAllowed checks if a key is legitimate or should be added to
     * the field value collection
     */
    protected function isKeyAllowed($key)
    {
        // Let the core columns through
        if (in_array($key, ['id', 'value', 'parent_id'])) {
            return true;
        }

        // Let relations through
        if ($this->hasRelation($key)) {
            return true;
        }

        return false;
    }
}
