<?php
declare(strict_types=1);

namespace TaroHida\Twitter\Tweet;

use TaroHida\Twitter\Tweet\Exception\UserIdValidateException;

class UserId
{
    private int $id;

    /**
     * @throws UserIdValidateException
     */
    public function __construct(int $user_id)
    {
        self::validate($user_id);
        $this->id = $user_id;
    }

    /**
     * @throws UserIdValidateException
     */
    public static function validate(int $user_id): void
    {
        if (!(0 < $user_id && $user_id <= 9223372036854775807)) {
            throw new UserIdValidateException();
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

}