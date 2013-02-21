<?php

/**
 *  Project: TeamspeakWatcher
 * 
 *  File: config.php
 * 
 *  Author: Felix Kastner (felix@chapterfain.com)
 *  Date: Winter 2012
 * 
 *  Summary of File:
 *  
 *      Sets the configuration values
 * 
 */

// Your ServerQuery details
$cfg['host'] = 'localhost';
$cfg['query'] = 10011;
$cfg['voice'] = 9987;
$cfg['serverinstance'] = 1;

// Your ServerQuery account
$cfg["user"] = 'ohnoes';
$cfg["pass"] = 'sensitivedata';

// Your MySQL serverinfo & credentials
$mysql['host'] = 'localhost';
$mysql['user'] = 'mygod';
$mysql['pass'] = 'everyoneknowsmypass';
$mysql['db'] = 'ts3cleanup';

// The channel deletion specifications
$maxInactivity = (3 * 24 * 60 * 60);
$minChecks = 1000;