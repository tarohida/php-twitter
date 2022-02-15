<?php
/** @noinspection NonAsciiCharacters */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpPrivateFieldCanBeLocalVariableInspection */
/** @noinspection PhpExpressionResultUnusedInspection */
/** @noinspection PhpStaticAsDynamicMethodCallInspection */
declare(strict_types=1);

namespace Tests\Twitter\Tweet;

use PHPUnit\Framework\TestCase;
use TaroHida\Twitter\Tweet\User;

class UserTest extends TestCase
{
    private int $id;
    private string $screen_name;
    private string $name;
    private string $profile_image_url;
    /**
     * @var User
     */
    private User $user;
    private string $profile_image_url_from_twitter;

    public function test_construct()
    {
        $this->assertInstanceOf(User::class, $this->user);
    }

    public function test_method_id()
    {
        $this->assertSame($this->id, $this->user->id());
    }

    public function test_method_screenName()
    {
        $this->assertSame($this->screen_name, $this->user->screenName());
    }

    public function test_method_name()
    {
        $this->assertSame($this->name, $this->user->name());
    }

    public function test_method_profileImageUrl()
    {
        $this->assertSame($this->profile_image_url, $this->user->profileImageUrl());
    }

    public function test_method_getHighResolutionProfileImageUrl()
    {
        $user = new User(
            $this->id,
            $this->screen_name,
            $this->name,
            $this->profile_image_url_from_twitter
        );
        $this->assertSame($this->profile_image_url_from_twitter, $user->profileImageUrl());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->id = 1;
        $this->screen_name = 'screen_name1';
        $this->name = 'name1';
        $this->profile_image_url_from_twitter = 'https://domain.test/path/to/image_normal.png';
        $this->profile_image_url = 'https://domain.test/path/to/image.png';
        $this->user = new User(
            $this->id,
            $this->screen_name,
            $this->name,
            $this->profile_image_url
        );
    }
}
