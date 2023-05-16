<?php
class Applicant extends User
{
    public $applicant_id;
    public $firstname;
    public $lastname;
    public $birthdate;
    public $description;
    public $allow_headhunting;
    public $user_id;
    public $street_id;
    public $education;

    public function __construct($firstname, $lastname, $birthdate,$description, $allow_headhunting,$user_id, $street_id,$education)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->birthdate = $birthdate;
        $this->description = $description;
        $this->allow_headhunting = $allow_headhunting;
        $this->user_id = $user_id;
        $this->street_id = $street_id;
        $this->education = $education;
        parent::__construct(null,null);
    }
}