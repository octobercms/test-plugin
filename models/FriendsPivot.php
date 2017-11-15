<?php namespace October\Test\Models;

use October\Rain\Database\Pivot;

class FriendsPivot extends Pivot
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
        'status' => 'required'
    ];

    public $belongsTo = [
        'user' => ['RainLab\User\Models\User', 'key' => 'user_id'],
        'friend' => ['RainLab\User\Models\User', 'key' => 'friend_id']
    ];

    public function getStatusOptions()
    {
        return [
            1 => 'Pending',
            2 => 'Approved',
            3 => 'Blocked',
        ];
    }

    public function afterSave()
    {
        if(!$this->friend->isFriendWith($this->user)) {
            $this->friend->addFriend($this->user);
        }
    }

    public function beforeDelete()
    {
        if($this->friend->isFriendWith($this->user)) {
            $this->friend->removeFriend($this->user);
        }
    }
}