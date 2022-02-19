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
use TaroHida\Twitter\Tweet\FavoriteClientInterface;
use TaroHida\Twitter\Tweet\QuoteRetweetClientInterface;
use TaroHida\Twitter\Tweet\RetweetClientInterface;
use TaroHida\Twitter\Tweet\Tweet;

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
        self::assertSame($user_id, $tweet->getUserId());
        self::assertSame($screen_name, $tweet->getUserScreenName());
        self::assertSame($name, $tweet->getUserName());
        self::assertSame($profile_image_url, $tweet->getUserProfileImageUrl());
    }

    public function test_method_satisfy()
    {
        $this->assertSatisfy(true, 1);
        $this->assertSatisfy(false, 2);
    }

    private function assertSatisfy(bool $expected, int $id)
    {
        $factory = new TweetFactory();
        $factory->setId($id);
        $tweet = $factory->createInstance();
        $specification = new SpecificationExample();
        self::assertSame($expected, $tweet->matchTo($specification));
    }

    public function test_method_retweetBy()
    {
        $id = 39;
        $factory = new TweetFactory();
        $factory->setId($id);
        $tweet = $factory->createInstance();
        $client = $this->createMock(RetweetClientInterface::class);
        $client->expects(self::once())
            ->method('retweet')
            ->with($id);
        $tweet->retweetBy($client);
    }

    public function test_method_favoriteBy()
    {
        $id = 39;
        $factory = new TweetFactory();
        $factory->setId($id);
        $tweet = $factory->createInstance();
        $client = $this->createMock(FavoriteClientInterface::class);
        $client->expects(self::once())
            ->method('favorite')
            ->with($id);
        $tweet->favoriteBy($client);
    }

    public function test_method_quoteRetweetBy()
    {
        $id = 39;
        $tweet_message = 'test message.';
        $factory = new TweetFactory();
        $factory->setId($id);
        $tweet = $factory->createInstance();
        $client = $this->createMock(QuoteRetweetClientInterface::class);
        $client->expects(self::once())
            ->method('postQuoteTweetWith')
            ->with(
                $this->callback(function (Tweet $tweet) use ($id) {
                    return $tweet->getId() === $id;
                }),
                $tweet_message
            );
        $tweet->quoteBy($client, $tweet_message);
    }
}
