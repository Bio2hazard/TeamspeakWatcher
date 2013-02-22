<?php

/**
 *  Project: TeamspeakWatcher
 * 
 *  File: index.php
 * 
 *  Author: Felix Kastner (felix@chapterfain.com)
 *  Date: Winter 2012
 * 
 *  Requires: TS3 PHP Framework ( http://docs.planetteamspeak.com/ts3/php/framework/index.html )
 * 
 *  Usage: This project is intended to be run from the console. Example usage: 
 * * / 2     *       *       *       *       /usr/bin/php -f /usr/TeamspeakWatcher/index.php >/usr/TeamspeakWatcher/errorlog 2>/usr/TeamspeakWatcher/errorlog
 * 
 *  Summary of File:
 *  
 *      Sets runtime values and loads configuration and code files.
 * 
 * Summary of Project:
 * 
 *      This project helps Teamspeak 3 admins to automatically purge Semi-Permanent channels after a period of inactivity.
 * 
 */

error_reporting(E_ALL | E_STRICT); // For production, you may want to comment this out.
date_default_timezone_set("Europe/Berlin"); // Adjust the time-zone to your region.

// Load required files
require_once("config.php");

// Load framework library
require_once("/usr/TeamspeakWatcher/libraries/TeamSpeak3/TeamSpeak3.php");

// Initialize
TeamSpeak3::init();

// Load the actual code
include_once("channelcheck.php");