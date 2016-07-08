<?php
/**
 * Created by PhpStorm.
 * User: gripinskiy
 * Date: 06.05.16
 * Time: 22:02
 */

namespace webarch\buser\app;


use webarch\buser\model\UserData;
use webignition\JsonPrettyPrinter\JsonPrettyPrinter;

class FormatHelper
{
    /**
     * @var JsonPrettyPrinter
     */
    private $jsonPrettyPrinter;

    function __construct()
    {
        $this->jsonPrettyPrinter = new JsonPrettyPrinter();
    }


    public function formatBxError($error)
    {
        return $this->formatJson(explode("<br>", $error));
    }

    public function formatUserInfo(UserData $user)
    {
        return $this->formatJson($user->toArray());
    }

    public function formatJson($data)
    {
        return $this->jsonPrettyPrinter->format(json_encode($data, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE));
    }


}
