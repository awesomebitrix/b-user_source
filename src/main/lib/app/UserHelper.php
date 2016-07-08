<?php

namespace webarch\buser\app;

use COption;
use CUser;
use RuntimeException;
use webarch\buser\ErrorCode;
use webarch\buser\model\UserData;

class UserHelper
{
    const LOW_ALPHA = "abcdefghijklmnopqrstuvwxyz";
    const UP_ALPHA = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const DIGITS = "0123456789";
    const SYMBOLS = ",.<>/?;:'\"[]{}\\|`~!@#$%^&*()-_+=";

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
            $arChars[] = self::LOW_ALPHA;
        }
        if ($groupPolicy["PASSWORD_UPPERCASE"] == "Y") {
            $arChars[] = self::UP_ALPHA;
        }
        if ($groupPolicy["PASSWORD_DIGITS"] == "Y") {
            $arChars[] = self::DIGITS;
        }
        if ($groupPolicy["PASSWORD_PUNCTUATION"] == "Y") {
            $arChars[] = self::SYMBOLS;
        }

        if (is_array($arChars) && count($arChars) <= 0) {
            $arChars[] = self::LOW_ALPHA;
            $arChars[] = self::DIGITS;
        }

        $length = (int)$groupPolicy["PASSWORD_LENGTH"];
        if ($length < 6) {
            $length = 8;
        }

        return randString($length, $arChars);
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
        $this->checkNewUser($user);
        $newUserId = $this->CUser->Add($user->toArray());
        if ($newUserId === false) {
            throw new RuntimeException(
                "Error creating user account: \n" . App::getInstance()->getFormatHelper()->formatBxError($this->CUser->LAST_ERROR),
                ErrorCode::USER_ADD_FAILURE
            );
        }
        return (int)$newUserId;
    }

    private function checkNewUser(UserData $user)
    {
        if (trim($user->getEmail()) == "" && COption::GetOptionString("main", "new_user_email_required", "N") == "Y") {
            throw new RuntimeException("Email is required", ErrorCode::USER_ADD_FAILURE);
        }
        if (!check_email($user->getEmail())) {
            throw new RuntimeException("Wrong email: `" . (string)$user->getEmail() . "`", ErrorCode::USER_ADD_FAILURE);
        }
        if (trim($user->getLogin())) {
            throw new RuntimeException("Login is required", ErrorCode::USER_ADD_FAILURE);
        }
    }
}
