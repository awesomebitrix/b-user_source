<?php

namespace webarch\buser\app;

use COption;
use CUser;
use RuntimeException;
use webarch\buser\ErrorCode;
use webarch\buser\model\UserData;

class UserHelper
{
    /**
     * @var CUser
     */
    private $CUser;

    function __construct()
    {
        $this->CUser = new CUser();
    }


    public function generatePassword(array $groups)
    {
        $groupPolicy = $this->CUser->GetGroupPolicy($groups);
        $arChars = [];
        if ($groupPolicy["PASSWORD_LOWERCASE"] == "Y") {
            $arChars[] = "abcdefghijklmnopqrstuvwxyz";
        }
        if ($groupPolicy["PASSWORD_UPPERCASE"] == "Y") {
            $arChars[] = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        }
        if ($groupPolicy["PASSWORD_DIGITS"] == "Y") {
            $arChars[] = "0123456789";
        }
        if ($groupPolicy["PASSWORD_PUNCTUATION"] == "Y") {
            $arChars[] = ",.<>/?;:'\"[]{}\\|`~!@#$%^&*()-_+=";
        }
        return randString($groupPolicy["PASSWORD_LENGTH"], $arChars);
    }

    /**
     * @param $isAdmin
     * @return array
     */
    public function getFutureGroups($isAdmin)
    {
        $groups = [1];
        if (!(bool)$isAdmin) {
            $groups = explode(",", COption::GetOptionString("main", "new_user_registration_def_group", "2"));
            return $groups;
        }
        return $groups;
    }

    public function addUser(UserData $user)
    {
        $userFields = [
            "LOGIN" => $user->getLogin(),
            "EMAIL" => $user->getEmail(),
            "PASSWORD" => $user->getPassword(),
            "PASSWORD_CONFIRM" => $user->getPasswordConfirm(),
            "GROUP_ID" => $user->getGroups()
        ];
        if (trim($user->getLastName()) != "") {
            $userFields["LAST_NAME"] = $user->getLastName();
        }
        if (trim($user->getFirstName()) != "") {
            $userFields["NAME"] = $user->getFirstName();
        }
        if (trim($user->getSecondName()) != "") {
            $userFields["SECOND_NAME"] = $user->getSecondName();
        }
        $newUserId = $this->CUser->Add($userFields);
        if ($newUserId === false) {
            throw new RuntimeException(
                "Error creating user account: \n" . App::getInstance()->getFormatHelper()->formatBxError($this->CUser->LAST_ERROR),
                ErrorCode::USER_ADD_FAILURE
            );
        }
        return (int)$newUserId;
    }
}