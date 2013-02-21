# TeamspeakWatcher


This script uses the TS3 PHP Framework to connect to your TS3's ServerQuery console.
Afterwards, it will query all semi-permanent channels to determine their status ( empty or populated ) and log the results to a MySQL database.
If a channel is determined to be abandoned ( via a configurable timelimit ) and has been checked a sufficient number of times ( also configurable ) it will remove the channel.

**Requires: TS3 PHP Framework ( http://docs.planetteamspeak.com/ts3/php/framework/index.html )**

**Usage**: This project is intended to be run from the console. Example usage ( as a crontab ):
`*/2     *       *       *       *       /usr/bin/php -f /usr/TeamspeakWatcher/index.php >/usr/TeamspeakWatcher/errorlog 2>/usr/TeamspeakWatcher/errorlog`


Author: Felix Kastner (felix@chapterfain.com)

Creation date: Winter 2012