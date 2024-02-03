<?php
class Campaigns
{
    /**
     *
     */
    public function __construct()
    {
    }

    /**
     *
     */
    public function __destruct()
    {
    }

    /**
     * Set friendly columns\' names to order tables\' entries
     */
    public function setOrderingValues()
    {
        $ordering = [
            'camp_id' => 'Campaign ID',
            'camp_name' => 'Campgaign Name',
            'camp_host' => 'Campaign Host',
            'camp_status' => 'Campaign Status'
        ];

        return $ordering;
    }
    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}
