<?php
   namespace app\models;
   use Yii;
   use yii\base\Model;
   use app\Model\Form;
   class RegistrationForm extends Model {
    //   public $username;
    //   public $password;
    //   public $email;
    //   public $subscriptions;
    //   public $photos;
    public $first_name;
    public $last_name;
    public $email_address;
    public $profile_picture;
    public $marks;
    public $status;


    public function rules(){
        return [
            [['first_name','last_name','email_address','marks','status'],'required','message'=>'Mandatory field'],
            ['email_address','email'],
            ['marks','double'],
            [['profile_picture'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg, png'],
        ];
    }


    public function upload() {
        if ($this->validate()) {
           $this->profile_picture->saveAs('../uploads/' . $this->profile_picture->baseName . '.' .
              $this->profile_picture->extension);
           return true;
        } else {
           return false;
        }
     }

     public function registration(){
         $form  = new Form();
         $form->first_name = $this->first_name;
         $form->last_name = $this->last_name;
         $form->email_address = $this->email_address;
         $form->profile_picture = $this->profile_picture;
         $form->marks = $this->marks;
         $form->status = $this->status;
         $form->save();

     }
      /**
      * @return array customized attribute labels
      */
      public function attributeLabels() {
         return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email_address' => 'Email ID',
            'profile_picture' => 'Profile Picture',
            'marks' => 'Marks',
            'status' => 'Status',
         ];
      }
   }
?>