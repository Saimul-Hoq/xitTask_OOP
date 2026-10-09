<?php

require_once(__DIR__."/../Controller.php");
require_once(__DIR__."/../../models/auth/SignupModel.php");



class SignupControllerPOST extends Controller
{
    private string $id;
    private string $email;
    private string $password;
    private string $name;
    private string $mobile;
    private string $address;
    private ?array $avatar;
    private string $avatarFilename;
    private int $role;
    private array $errors;
    private array $old;
    private $model;

    public function __construct(array $data)
    {
        $this->id = $this->generateId();
        $this->email = $data["email"];
        $this->password = $data["password"];
        $this->name = $data["name"];
        $this->mobile = $data["mobile"];
        $this->address = $data["address"];
        $this->avatar = $data["avatar"] ?? null;
        $this->avatarFilename = "default.png";
        $this->role = 2;
        $this->errors = [];
        $this->old = [];
        $this->model = new SignupModel();
    }

    public function index()
    {
        if(!$this->model->verifyDbConnection()){
            $this->fail(true);
        }

        if($this->isEmpty()){
            $this->fail();
        }

        if(!$this->validate()){
            $this->fail();
        }

        $this->isInputTaken();

        if(!$this->saveAvatar()){
            $this->fail();
        }

        $this->request();

    }

    private function request(){

        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        $check = $this->model->createSignupRequest( $this->id,  $this->email,  $this->password,  $this->name,  $this->mobile,  $this->address,  $this->avatarFilename,  $this->role);

        if($check === false){
            $this->fail(true);
        }
        else{
            $this->success();
        }
        
    }

    private function isInputTaken()
    {
        $checkEmail = $this->model->emailExists($this->email);
        if($checkEmail === false){
            $this->fail(true);
        }
        elseif($checkEmail){
            $this->errors["email"] = "This email is already in use";
            $this->fail();
        }

        $checkMobile = $this->model->mobileExists($this->mobile);
        if($checkMobile === false){
            $this->fail(true);
        }
        elseif($checkMobile){
            $this->errors["mobile"] = "This number is already in use";
            $this->fail();
        }
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

        //Email
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors["email"] = "Invalid email format.";
            $check = false;
        } 

        //Password
        if (strlen($this->password) < 4) {
            $this->errors["password"] = "Password must be at least 4 characters.";
            $check = false;
        }

        //Mobile
        if (!preg_match('/^01[0-9]{9}$/', $this->mobile)) {
            $this->errors["mobile"] = "Invalid Phone Number";
            $check = false;
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
        if ($this->avatar === null || $this->avatar['error'] === UPLOAD_ERR_NO_FILE) {
            return true;
        }

        $destination = __DIR__ . "/../../uploads/" . $this->avatarFilename;

        if (!move_uploaded_file($this->avatar['tmp_name'], $destination)) {
            error_log("saveAvatar Error: failed to move uploaded file to " . $destination);
            $this->errors["disk"] = "Failed to save avatar. Please try again later";
            return false;
        }

        return true;
    }

    private function isEmpty() : bool
    {
        $check = false;

        if (trim($this->email) === '') {
            $this->errors["email"] = "Email is required";
            $check = true;
        }

        if (trim($this->password) === '') {
            $this->errors["password"] = "Password is required";
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

        return $check;
    }

    private function success()
    {
        $this->view("signup.php", ["errors" => [], "success" => true]);
        exit();
    }

    private function fail($db = false) : void
    {   
        if($db){
            $this->errors["db"] = "Database Connection Failed. Please try again later";
        }
        $this->old["email"] = $this->email;
        $this->old["name"] = $this->name;
        $this->old["mobile"] = $this->mobile;
        $this->old["address"] = $this->address;


        $this->view("signup.php", ["errors" => $this->errors, "old" => $this->old, "success" => false]);
        exit();
    }

    private function generateId(): string
    {
        $data = random_bytes(16);

        // Set version to 0100 (UUID v4)
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        // Set variant to 10xx
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }


}