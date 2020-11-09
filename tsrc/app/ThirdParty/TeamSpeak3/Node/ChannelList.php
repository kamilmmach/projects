<?php

class TeamSpeak3_Node_ChannelList
{
    protected $head = null;
    protected $tail = null;

    public function __construct()
    {
    }

    public function buildFromArray(&$array)
    {
        $first = array_pop($array);
        $this->head = new TeamSpeak3_Node_ChannelListNode($first);
        
        $current_node = $this->head;
        
        while(count($array) > 0)
        {
            $next_node = new TeamSpeak3_Node_ChannelListNode(end($array));
            reset($array);

            if($next_node->channel['pid'] == $current_node->channel['pid'])
            {
                $next_node->setPrev($current_node);
                $current_node->setNext($next_node);

                if($current_node->parent() != null)
                    $next_node->setParent($current_node->parent());
            }
            else if($next_node->channel['pid'] > $current_node->channel['pid']) // child channel
            {
                $channelList = new TeamSpeak3_Node_ChannelList();
                $channelList->buildFromArray($array);

                $current_node->setChild($channelList);
                $channelList->getHead()->setParent($current_node);

                continue;
            }
            else
                break;

            $current_node = $next_node;
            array_pop($array);
        }

        $this->tail = $current_node;

    }

    public function getHead()
    {
        return $this->head;
    }
}