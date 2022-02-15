<?php
/** @noinspection NonAsciiCharacters */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpPrivateFieldCanBeLocalVariableInspection */
declare(strict_types=1);

namespace Tests\Twitter\Tweet;

use PHPUnit\Framework\TestCase;
use TaroHida\Twitter\Tweet\Exception\UserIdValidateException;
use TaroHida\Twitter\Tweet\UserId;

class UserIdTest extends TestCase
{
    private int $user_id_num;
    private UserId $user_id;

    public function invalidConstructParamsProvider(): array
    {
        return [
            [0],
            [-1],
            // 92233720368547758078 は float にキャストされるのでテストする必要はない
        ];
    }

    public function validParamsProvider(): array
    {
        return [
            [1],
            'Int型の最大値 + 1' => [2147483647 + 1],
            'BigInt型の最大値' => [9223372036854775807]
        ];
    }

    public function test_method_getId()
    {
        self::assertSame($this->user_id_num, $this->user_id->getId());
    }

    /**
     * @dataProvider invalidConstructParamsProvider
     */
    public function test_construct_throw_ValidateException(int $user_id)
    {
        try {
            new UserId($user_id);
            static::fail('expect exception');
        } catch (UserIdValidateException $ex) {
            self::assertTrue(true);
        }
    }

    /**
     * @dataProvider validParamsProvider
     */
    public function test_construct_not_throw_ValidateException(int $user_id)
    {
        $id = new UserId($user_id);
        static::assertInstanceOf(UserId::class, $id);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user_id_num = 1;
        $this->user_id = new UserId($this->user_id_num);
    }
}
