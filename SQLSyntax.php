<?php
class SQLSyntax
{
    
    public function get($idx)
    {
        return BIOS::activeOs()->getConf($idx);
    }
}