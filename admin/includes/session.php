<?php 
class Session {
    private $signedIn = false;
    public $user_id;
    public $message;

    public function __construct()
    {
        session_start();
        $this->checkLogin();
        $this->checkMessage();
    }
    public function messege($msg = ""){
        if(!empty($msg)){
            $_SESSION['message'] = $msg;
        }else{
            return $this->message;
        }
    }
    public function checkMessage(){
        if(isset($_SESSION['message'])){
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        }else{
            $this->message = "";
        }
    }
    public function login($user){
        if($user){
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->signedIn = true;
        }
    }
    public function isSignedIn(){
        return $this->signedIn;
    }
    public function logout(){
       unset($_SESSION['user_id']);
       unset($this->user_id);
        $this->signedIn = false;
    }
    private function checkLogin(){
        if(isset($_SESSION['user_id'])){
            $this->user_id = $_SESSION['user_id'];
            $this->signedIn = true;
        }else{
            unset($this->user_id);
            $this->signedIn = false;
        }
    }
}
$session = new Session();