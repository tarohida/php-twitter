<?php
/** @noinspection NonAsciiCharacters */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpPrivateFieldCanBeLocalVariableInspection */
/** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

namespace Tests\TaroHida\Twitter\Tweet;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use stdClass;

class TweetTest extends TestCase
{
    public function test_method_getter()
    {
        $id = 1;
        $datetime = new DateTimeImmutable('now');
        $entities = new stdClass();
        $source = 'source';
        $text = 'text';
        $user_id = 1;
        $screen_name = 'screen_name';
        $name = 'name';
        $profile_image_url = 'https://example.example/path/to/image_normal.png';
        $factory = new TweetFactory(
            $id, $datetime, $entities, $source, $text, $user_id, $screen_name, $name, $profile_image_url
        );
        $tweet = $factory->createInstance();
        self::assertSame($id, $tweet->getId());
        self::assertSame($datetime, $tweet->getDateTime());
        self::assertSame($entities, $tweet->getEntities());
        self::assertSame($source, $tweet->getSource());
        self::assertSame($text, $tweet->getText());
        self::assertSame($user_id, $tweet->getUser()->id());
        self::assertSame($screen_name, $tweet->getUser()->screenName());
        self::assertSame($name, $tweet->getUser()->name());
        self::assertSame($profile_image_url, $tweet->getUser()->profileImageUrl());
    }
}
