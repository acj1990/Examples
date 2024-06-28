<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CreateUserForm extends Model
{
    public $username;
    public $permissions;
    public $fname;
    public $lname;
    public $temppw;
    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // index required
            [['username','permissions','fname','lname','temppw','email'], 'required'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'permissions' => 'Permission Level',
            'fname' => 'First Name',
            'lname' => 'Last Name',
            'temppw' => 'Temporary Password',
            'email' => 'User Email',
        ];
    }
}
