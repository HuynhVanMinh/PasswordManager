<?php
/**
 * Created by PhpStorm.
 * User: minh
 * Date: 5/25/18
 * Time: 11:11 PM
 */


class PasswordManager
{

    private $user_name;
    private $encrypted_password;

    /**
     * set User name
     *
     * @param string $user_name
     */
    public function setUserName(string $user_name)
    {
        $this->user_name = $user_name;
    }

    /**
     * Encrypt Password
     *
     * @param string $password
     * @return string
     */
    protected function encrypt(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verify Password
     *
     * @param string $password
     * @return bool
     */
    protected function verifyPassword(string $password): bool
    {
        if (password_verify($password, $this->encrypted_password))
            return true;
        return false;
    }

    /**
     * Validate Password
     *
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        echo '--------------Begin Validate------------------<br>';
        $flag = true;

        //The password must not contain any whitespace
        if (preg_match('/\s/', $password)) {
            echo 'The password must not contain any whitespace. <br>';
            $flag = false;
        }

        //The password must be at least 6 characters long.
        if (strlen($password) < 6) {
            echo 'The password must be at least 6 characters long. <br>';
            $flag = false;
        }

        //The password must contain at least one uppercase and at least one lowercase letter.
        if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])/", $password)) {
            echo 'The password must contain at least one uppercase and at least one lowercase letter. <br>';
            $flag = false;
        }

        //The password must have at least one digit and symbol.
        if (!preg_match("/^(?=.*\d)(?=.*\W+)/", $password)) {
            echo 'The password must have at least one digit and symbol. <br>';
            $flag = false;
        }

        echo '-------------------End Validate---------------------<br>';
        return $flag;
    }

    /**
     * Set new Password
     *
     * @param string $proposed_password
     * @return bool
     */
    public function setNewPassword(string $proposed_password): bool
    {
        if ($this->validatePassword($proposed_password)) {
            $this->encrypted_password = $this->encrypt($proposed_password);
            return true;
        }

        return false;
    }


    /** Store and load file password.txt **/
    private $filename = 'password.txt';


    /**
     * Store data file password.txt
     *
     * @return bool
     */
    public function store():boo
    {
        $data = json_encode([
            'user_name' => $this->user_name,
            'encrypted_password' => $this->encrypted_password
        ]);
        file_put_contents($this->filename, $data);
        echo 'Username and encrypted password has been store a file “password.txt” <br>';
        return true;
    }

    /**
     * Load file password.txt
     *
     * @return bool
     */
    public function load(): bool
    {
        $data_content_file = file_get_contents($this->filename);
        if ($data_content_file) {
            $data = json_decode($data_content_file, true);
            $this->user_name = $data['user_name'];
            $this->encrypted_password = $data['encrypted_password'];
            echo 'Username and encrypted password has been load a file “password.txt” <br>';
            return true;
        }
        echo 'File not exist!';
        return false;
    }


    /**
     * Verify pasword
     *
     * @param string $password
     * @return bool
     */
    public function verifyPasswordPublic(string $password)
    {
        if ($this->verifyPassword($password)) {
            echo 'Password correct!<br>';
            return true;
        }
        echo 'Password incorrect!<br>';
        return false;

    }
}