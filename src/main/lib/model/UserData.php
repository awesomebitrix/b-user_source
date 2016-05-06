<?php

namespace webarch\buser\model;

class UserData
{
    private $id;
    private $email;
    private $login;
    private $password;
    private $passwordConfirm;
    private $lastName;
    private $firstName;
    private $secondName;
    /**
     * @var array
     */
    private $groups = [];

    function __construct($email, $login, $password = null, $passwordConfirm = null)
    {
        $this->setEmail($email);
        if (trim($login) != "") {
            $this->setLogin($login);
        } else {
            $this->setLogin($email);
        }
        if (!is_null($password) && trim($password) != "") {
            $this->setPassword($password);
        }
        if (!is_null($passwordConfirm) && trim($passwordConfirm) != "") {
            $this->setPasswordConfirm($passwordConfirm);
        }
    }


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = trim($email);
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = trim($login);
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = trim($password);
    }

    /**
     * @return mixed
     */
    public function getPasswordConfirm()
    {
        return $this->passwordConfirm;
    }

    /**
     * @param mixed $passwordConfirm
     */
    public function setPasswordConfirm($passwordConfirm)
    {
        $this->passwordConfirm = trim($passwordConfirm);
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = trim($lastName);
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = trim($firstName);
    }

    /**
     * @return mixed
     */
    public function getSecondName()
    {
        return $this->secondName;
    }

    /**
     * @param mixed $secondName
     */
    public function setSecondName($secondName)
    {
        $this->secondName = trim($secondName);
    }

    /**
     * @return array
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param array $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}