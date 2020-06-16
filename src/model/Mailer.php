<?php

namespace Model;

class Mailer
{
    protected $postData;
    protected $tags = null;

    public function __construct(array $postData)
    {
        $this->postData = filter_var_array($postData, FILTER_SANITIZE_STRING);
        $this->_trimBody();
        return $this;
    }

    public function addPostID($id)
    {
        $this->postData['post_id'] = $id;
        return $this;
    }

    public function getPostData()
    {
        return $this->postData;
    }

    public function lookForTags()
    {
        $body = $this->postData['body'];
        return strpos($body, '#') !== false ? true : false;
    }

    public function stripTagsFromBody()
    {
        $pattern  = '/(#\w+)/';
        $body = $this->postData['body'];

        preg_match_all('/(#\w+)/',  $body, $tags, PREG_PATTERN_ORDER);
        $body = preg_replace($pattern, '', $body);

        $this->tags = implode(';', $tags[1]);
        $this->postData['body'] = $body;
        $this->_trimBody();

        return $this;
    }

    public function addTags()
    {
        $this->postData['tags'] =  $this->tags;
        return $this;
    }

    public function addNoTags()
    {
        $this->postData['tags'] = null;
        return $this;
    }

    protected function _trimBody()
    {
        $this->postData['body'] = trim($this->postData['body']);
        return $this;
    }
}
