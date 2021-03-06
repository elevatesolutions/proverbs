<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use app\rbac\models\Role;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property integer $status
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $account_activation_token
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $gender
 * @property string $birth_date
 * @property string $address
 * @property integer $phone
 * @property integer $mobile
 * @property string $notes
 */
class ProfileForm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['phone', 'mobile', 'gender','created_at', 'updated_at'], 'integer'],
            [['birth_date'], 'safe'],
            [['username', 'email', 'address', 'notes'], 'string', 'max' => 255],
            [['first_name', 'middle_name', 'last_name'], 'string', 'max' => 45],
            [['profile_image'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'status' => 'Status',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'account_activation_token' => 'Account Activation Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'gender' => 'Gender',
            'birth_date' => 'Birth Date',
            'address' => 'Address',
            'phone' => 'Phone',
            'mobile' => 'Mobile',
            'notes' => 'Notes',
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            [
                'class' => 'mdm\upload\UploadBehavior',
                'attribute' => 'file', // required, use to receive input file
                'savedAttribute' => 'profile_image', // optional, use to link model with saved file.
                'uploadPath' => '@webroot/uploads/users', // saved directory. default to '@runtime/upload'
                'autoSave' => true, // when true then uploaded file will be save before ActiveRecord::save()
                'autoDelete' => true, // when true then uploaded file will deleted before ActiveRecord::delete()
            ],
        ];
    }

    public function formatDate($date){
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        if(strpos($date, '/') !== false){

            $m = trim(substr($date, 0, 2));
            $d = trim(substr($date, 3, 2));
            $Y = substr($date, 6, 4);
            $this->birth_date = $Y . '-' . $m . '-' . $d;
            $date = $this->birth_date;

            return $date;
        }

        if(strpos($date, ',') !== false){
            if(strlen($date) === 12){
                $m = trim(substr($date, 0, 3));

                for($i = 0; $i <= 11; $i++){
                    if($months[$i] === $m){
                        $m = $i+=1;
                        $d = trim(substr($date, 4, 2));
                        $Y = substr($date, 8, 4);
                        $this->birth_date = $this->birth_date = $Y . '-' . $m . '-' . $d;
                        $date = $this->birth_date;

                        return $date;
                    }
                }
            } else {
                $m = trim(substr($date, 0, 3));
                
                for($i = 0; $i <= 11; $i++){
                    if($months[$i] === $m){
                        $m = $i+=1;
                        $d = substr($date, 4, 1);
                        $Y = substr($date, 7, 4);
                        $this->birth_date = $this->birth_date = $Y . '-' . $m . '-' . $d;
                        $date = $this->birth_date;

                        return $date;
                    }
                }
            }
        }

    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord){
                $this->formatDate($this->birth_date);
                return true;
            } else {
                $this->formatDate($this->birth_date);
                return true;
            }
        } else {
            return false;
        }
    }

    public function getRole()
    {
        // User has_one Role via Role.user_id -> id
        return $this->hasOne(Role::className(), ['user_id' => 'id']);
    }

    public function getGenderName($data)
    {
        if($data === 0) {
            return 'Male';
        }else {
            return 'Female';
        }
    }

    public function getStatusName($data)
    {
        if($data === 10) {
            return 'Active';
        }elseif($data === 10) {
            return 'Inactive';
        }else {
            return 'Deleted';
        }
    }

    public function getRoleName()
    {
        return $this->role->item_name;
    }

    public function getAssignedRole($id){
        $array = Yii::$app->authManager->getRolesByUser($id);
        
         $role = [];

        foreach ($array as $key) {
            $role = $key;
        }

        return $role->name;
    }
}
