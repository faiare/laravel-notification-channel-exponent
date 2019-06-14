<?php

namespace NotificationChannels\Exponent;

/**
 * Class ExponentMessage.
 */
class ExponentMessage
{
    protected $tokens = [];

    protected $title;
    protected $body;

    protected $sound = 'default';

    protected $badge = 0;

    protected $ttl = 0;

    protected $channelId = 'Default';

    protected $jsonData = [];

    public static function create()
    {
        return new static();
    }

    /**
     * @param array $tokens
     * @return ExponentMessage
     */
    public function setTokens($tokens)
    {
        $this->tokens = $tokens;

        return $this;
    }

    /**
     * @param mixed $title
     * @return ExponentMessage
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param mixed $body
     * @return ExponentMessage
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @param string $sound
     * @return ExponentMessage
     */
    public function setSound($sound)
    {
        $this->sound = $sound;

        return $this;
    }

    /**
     * @param int $badge
     * @return ExponentMessage
     */
    public function setBadge($badge)
    {
        $this->badge = $badge;

        return $this;
    }

    /**
     * @param int $ttl
     * @return ExponentMessage
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * @param string $channelId
     * @return ExponentMessage
     */
    public function setChannelId($channelId)
    {
        $this->channelId = $channelId;

        return $this;
    }

    /**
     * @param array $jsonData
     * @return ExponentMessage
     */
    public function setJsonData($jsonData)
    {
        $this->jsonData = $jsonData;

        return $this;
    }

    /**
     * @return array
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'sound' => $this->sound,
            'badge' => $this->badge,
            'ttl' => $this->ttl,
            'channelId' => $this->channelId,
            'data' => json_encode($this->jsonData),
        ];
    }
}
