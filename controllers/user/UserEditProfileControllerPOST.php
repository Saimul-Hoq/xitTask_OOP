<?php

require_once(__DIR__."/../Controller.php");
require_once(__DIR__."/../../models/user/UserEditProfileModel.php");

class UserEditProfileControllerPOST extends Controller
{
    private string $id;
    private ?string $currentPassword;
    private ?string $newPassword;
    private ?string $confirmPassword;
    private string $name;
    private string $mobile;
    private string $address;
    private ?array $avatar;
    private string $avatarFilename;
    private array $errors;
    private array $old;
    private $model;

    public function __construct(array $data)
    {
        $this->id = $_SESSION["id"] ?? "";
        $this->currentPassword = $data["currentPassword"] ?? null;
        $this->newPassword = $data["newPassword"] ?? null;
        $this->confirmPassword = $data["confirmPassword"] ?? null;
        $this->name = $data["name"];
        $this->mobile = $data["mobile"];
        $this->address = $data["address"];
        $this->avatar = $data["avatar"] ?? null;
        $this->avatarFilename = "default.png";
        $this->errors = [];
        $this->old = [];
        $this->model = new UserEditProfileModel();
    }

    public function index()
    {
        $this->requireLogin();

        if(!$this->model->verifyDbConnection()){
            $this->fail(true);
        }

        if($this->isEmpty()){
            $this->fail();
        }

        if(!$this->validate()){
            $this->fail();
        }

        $this->update();

        $this->success();
    }

    private function update()
    {
        $this->updateAddress();
        $this->updateAvatar();
        $this->updateMobile();
        $this->updateName();
        $this->updatePassword();
    }

    private function updateAvatar()
    {
        if ($this->avatar === null) {
            return true;
        }

        if ($this->saveAvatar() === false) {
            $this->errors["disk"] = "Failed to save avatar. Please try again later";
            $this->fail();
        }

        if ($this->model->editAvatar($this->id, $this->avatarFilename) === false) {
            $this->fail(true);
        }

        return true;
    }

    private function updateAddress()
    {
        if($this->model->editAddress($this->id, $this->address) === false){
            $this->fail(true);
        }

        return true;
    }


    private function updateName()
    {
        if($this->model->editName($this->id, $this->name) === false){
            $this->fail(true);
        }

        return true;
    }

    private function updatePassword()
    {
        if($this->currentPassword===null){
            return true;
        }

        $this->newPassword = password_hash($this->newPassword, PASSWORD_DEFAULT);
        if($this->model->editPassword($this->id, $this->newPassword) === false){
            $this->fail(true);
        }

        return true;
    }

    private function updateMobile()
    {
        $currentMobile = $this->model->getUserMobile($this->id);
        if($currentMobile === false){
            $this->fail(true);
        }
        elseif($currentMobile === $this->mobile){
            return true;
        }


        if($this->model->editMobile($this->id, $this->mobile) === false){
            $this->fail(true);
        }

        return true;
    }

    private function validate() : bool
    {
        $check = true;

        //Name
        if (!(strlen($this->name) > 1 && strlen($this->name) <= 20)) {
            $this->errors["name"] = "Name must be between 2 and 20 characters.";
            $check = false;
        } 
        elseif (!preg_match('/^[a-zA-Z ]+$/', $this->name)) {
            $this->errors["name"] = "Name cannot contain special characters.";
            $check = false;
        }

        //Address
        if(!preg_match('/^[a-zA-Z0-9 ,.\-\/#]+$/', $this->address)){
            $this->errors["address"] = "Address cannot contain special characters.";
            $check = false;
        }


        //Password
        if($this->newPassword !== null)
        {
            $password = $this->model->getUserPassword($this->id);
            if (strlen($this->newPassword) < 4) {
                $this->errors["newPassword"] = "Password must be at least 4 characters.";
                $check = false;
            }
            elseif($password === false){
                $this->fail(true);
            }
            elseif(!password_verify($this->currentPassword, $password)){
                $this->errors["currentPassword"] = "Current password is not correct";
                $check = false;
            }
            elseif($this->newPassword !== $this->confirmPassword){
                $this->errors["confirmPassword"] = "Password is not matched";
                $check = false;
            }
        }
        


        //Mobile
        $checkMobile = $this->model->isMobileExists($this->mobile, $this->id);
        if (!preg_match('/^01[0-9]{9}$/', $this->mobile)) {
            $this->errors["mobile"] = "Invalid Phone Number";
            $check = false;
        }
        elseif($checkMobile === false){
            $this->fail(true);
        }
        else if($checkMobile){
            $this->errors["mobile"] = "This mobile is already in use";
            $this->fail();
        }

        //Avatar
        if ($this->avatar !== null && $this->avatar['error'] !== UPLOAD_ERR_NO_FILE) {
            $tmpPath = $this->avatar['tmp_name'];

            if ($this->avatar['error'] !== UPLOAD_ERR_OK) {
                $this->errors["avatar"] = "Error uploading avatar.";
                $check = false;
            }
            else {
                $allowedMimes = [
                    "image/jpeg" => "jpg",
                    "image/png"  => "png",
                    "image/webp" => "webp",
                ];
                $realMime = mime_content_type($tmpPath);

                if (!array_key_exists($realMime, $allowedMimes)) {
                    $this->errors["avatar"] = "Invalid file type.";
                    $check = false;
                }
                elseif (filesize($tmpPath) > 2 * 1024 * 1024) {
                    $this->errors["avatar"] = "File too large. File must be within 2MB.";
                    $check = false;
                }
                else {
                    $this->avatarFilename = "user_" . $this->id . "." . $allowedMimes[$realMime];
                }
            }
        }

        return $check;
        
    }

    private function saveAvatar(): bool
    {
        if ($this->avatar === null) {
            return true;
        }

        $destination = __DIR__ . "/../../uploads/" . $this->avatarFilename;
        

        if (!move_uploaded_file($this->avatar['tmp_name'], $destination)) {
            error_log("saveAvatar Error: failed to move uploaded file to " . $destination);
            
            return false;
        }

        return true;
    }

    private function isEmpty() : bool
    {
        $check = false;


        if ($this->currentPassword!==null && trim($this->currentPassword) === '') {
            $this->errors["currentPassword"] = "Current Password is required";
            $check = true;
        }

        if ($this->newPassword!==null && trim($this->newPassword) === '') {
            $this->errors["newPassword"] = "New Password is required";
            $check = true;
        }

        if ($this->confirmPassword!==null && trim($this->confirmPassword) === '') {
            $this->errors["confirmPassword"] = "Confirm Password is required";
            $check = true;
        }


        if (trim($this->name) === '') {
            $this->errors["name"] = "Name is required";
            $check = true;
        }

        if (trim($this->mobile) === '') {
            $this->errors["mobile"] = "Mobile number is required";
            $check = true;
        }

        if (trim($this->address) === '') {
            $this->errors["address"] = "Address is required";
            $check = true;
        }

        if($this->avatar!==null && $this->avatar['error'] === UPLOAD_ERR_NO_FILE){
            $this->errors["avatar"] = "Avatar is required";
            $check = true;
        }

        return $check;
    }

    public function getUser()
    {
        $user = $this->model->getUser($this->id);
        if($user === false || $user === null){

            $this->redirect("/projects/xitTask_OOP/logout");
            exit();
        }
        return $user;
    }

    private function success()
    {
        $user = $this->getUser();
        $this->view("userEditProfile.php", ["errors" => [], "success" => true, "user" => $user]);
        exit();
    }

    private function fail($db = false) : void
    {   
        if($db){
            $this->errors["db"] = "Database Connection Failed. Please try again later";
        }
        $this->old["name"] = $this->name;
        $this->old["mobile"] = $this->mobile;
        $this->old["address"] = $this->address;

        $user = $this->getUser();
        $this->view("userEditProfile.php", 
            [
                "errors" => $this->errors,
                "old" => $this->old,
                "success" => false,
                "user" => $user,
                "open"    => [
                    "password" => $this->currentPassword !== null,
                    "avatar"   => $this->avatar !== null,
                    ]
            ]
        );
        exit();
    }

}