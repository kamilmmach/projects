<?php
class TeamSpeak3_Node_ChannelListNode
{
    public $channel = null;
    protected $next = null;
    protected $prev = null;
    protected $child = null;
    protected $parent = null;

    public function __construct($channel)
    {
        $this->channel = $channel;
    }

    public function next()
    {
        return $this->next;
    }

    public function prev()
    {
        return $this->prev;
    }

    public function child()
    {
        return $this->child;
    }

    public function parent()
    {
        return $this->parent;
    }

    public function setNext(TeamSpeak3_Node_ChannelListNode $next)
    {
        $this->next = $next;
    }

    public function setPrev(TeamSpeak3_Node_ChannelListNode $prev)
    {
        $this->prev = $prev;
    }

    public function setChild(TeamSpeak3_Node_ChannelList $child)
    {
        $this->child = $child;
    }

    public function setParent(TeamSpeak3_Node_ChannelListNode $parent)
    {
        $this->parent = $parent;
    }
    
}