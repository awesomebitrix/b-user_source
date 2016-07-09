<?php

namespace WebArch\BUser\Model;

class UserData
{
    /**
     * @var bool
     */
    private $active;
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

    function __construct($email = null, $login = null, $password = null, $passwordConfirm = null)
    {
        $this->withEmail($email);
        if (trim($login) != "") {
            $this->withLogin($login);
        } else {
            $this->withLogin($email);
        }
        if (!is_null($password) && trim($password) != "") {
            $this->withPassword($password);
        }
        if (!is_null($passwordConfirm) && trim($passwordConfirm) != "") {
            $this->withPasswordConfirm($passwordConfirm);
        }
    }

    public function toArray()
    {
        $fields = [];

        if (!is_null($this->active)) {
            $fields["ACTIVE"] = $this->isActive() ? "Y" : "N";
        }
        if (trim($this->getLogin()) != "") {
            $fields["LOGIN"] = $this->getLogin();
        }
        if (trim($this->getEmail()) != "") {
            $fields["EMAIL"] = $this->getEmail();
        }
        if (trim($this->getPassword()) != "") {
            $fields["PASSWORD"] = $this->getPassword();
        }
        if (trim($this->getPasswordConfirm()) != "") {
            $fields["PASSWORD_CONFIRM"] = $this->getPasswordConfirm();
        }
        if (is_array($this->getGroups()) != "") {
            $fields["GROUP_ID"] = $this->getGroups();
        }
        if (trim($this->getLastName()) != "") {
            $fields["LAST_NAME"] = $this->getLastName();
        }
        if (trim($this->getFirstName()) != "") {
            $fields["NAME"] = $this->getFirstName();
        }
        if (trim($this->getSecondName()) != "") {
            $fields["SECOND_NAME"] = $this->getSecondName();
        }

        return $fields;
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
     * @return UserData
     */
    public function withEmail($email)
    {
        $this->email = trim($email);
        return $this;
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
     * @return UserData
     */
    public function withLogin($login)
    {
        $this->login = trim($login);
        return $this;
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
     * @return UserData
     */
    public function withPassword($password)
    {
        $this->password = trim($password);
        return $this;
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
     * @return UserData
     */
    public function withPasswordConfirm($passwordConfirm)
    {
        $this->passwordConfirm = trim($passwordConfirm);
        return $this;
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
     * @return UserData
     */
    public function withLastName($lastName)
    {
        $this->lastName = trim($lastName);
        return $this;
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
     * @return UserData
     */
    public function withFirstName($firstName)
    {
        $this->firstName = trim($firstName);
        return $this;
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
     * @return UserData
     */
    public function withSecondName($secondName)
    {
        $this->secondName = trim($secondName);
        return $this;
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
     * @return UserData
     */
    public function withGroups($groups)
    {
        $this->groups = $groups;
        return $this;
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
     * @return UserData
     */
    public function withId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     * @return UserData
     */
    public function withActive($active)
    {
        $this->active = (bool)$active;
        return $this;
    }


}
