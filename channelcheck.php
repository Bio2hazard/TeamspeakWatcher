<?php

/**
 *  Project: TeamspeakWatcher
 * 
 *  File: channelcheck.php
 * 
 *  Author: Felix Kastner (felix@chapterfain.com)
 *  Date: Winter 2012
 * 
 *  Summary of File:
 *  
 *      Scans all Semi-Permanent channels of the Teamspeak 3 server, determining their activity.
 *      Empty channels are added to the database and duration of their inactivity is recorded.
 *      If the inactivity duration surpasses the limit, the channel is removed. 
 * 
 */

// Load the server instance
$ts3_ServerInstance = TeamSpeak3::factory('serverquery://' . $cfg['user'] . ':' . $cfg['pass'] . '@' . $cfg['host'] . ':' . $cfg['query'] . '/');
$ts3_VirtualServer = $ts3_ServerInstance->serverGetById($cfg['serverinstance']);

// Connect to the database
$mysqli = new mysqli($mysql['host'], $mysql['user'], $mysql['pass'], $mysql['db']);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Iterate through all channels
foreach($ts3_VirtualServer->channelList() as $channel) {
    if($channel['channel_flag_semi_permanent']) {        
        
        $channelId = $channel->getId();
        $channelName = $channel['channel_name'];
        
        // Add the channel to the database if it hasn't been recorded previously
        $stmt = $mysqli->prepare('INSERT IGNORE INTO channels (cid, emptySince, lastChecked, numEmptyChecks, channelName) values(?, now(), now(), 0, ?)');
        $stmt->bind_param('is', $channelId, $channelName);
        $stmt->execute();
        $stmt->close();        
        if($channel['total_clients']) {            
            // Since the channel has clients, we update the database to reflect that it is a active channel
            $stmt = $mysqli->prepare('UPDATE channels SET emptySince=now(), lastChecked=now(), numEmptyChecks=0, channelName=? WHERE cid=?');
            $stmt->bind_param('si', $channelName, $channelId);            
            $stmt->execute();
            $stmt->close();            
        } else {            
            // Since the channel is empty, we grab the duration in seconds that it has been empty for
            $stmt = $mysqli->prepare('SELECT UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(emptySince), numEmptyChecks FROM channels WHERE cid = ?');
            $stmt->bind_param('i', $channelId);
            $stmt->execute();            
            $stmt->bind_result($emptySince, $checks);            
            $stmt->fetch();
            $stmt->close();            
            if($emptySince > $maxInactivity && count($channel->subChannelList()) == 0 && $checks > $minChecks) {                
                // Channel has been inactive for too long, has no subchannels and has been checked a appropriate number of times; It's time to delete it.
                $ts3_VirtualServer->channelDelete($channelId);                
                $stmt = $mysqli->prepare('DELETE FROM channels WHERE cid = ?');
                $stmt->bind_param('i', $channelId);
                $stmt->execute();
                $stmt->close();                
            } else {
                // Channel does not meet the requirements for removal, and as such we simply record that it has been checked
                $stmt = $mysqli->prepare('UPDATE channels SET lastChecked=now(), numEmptyChecks=numEmptyChecks+1, channelName=? WHERE cid=?');
                $stmt->bind_param('si', $channelName, $channelId);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

$mysqli->close();
?>