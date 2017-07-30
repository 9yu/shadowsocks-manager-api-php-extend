# shadowsocks-manager-api-php-extend

Run SS  
> $ screen -S ss  
> $ ss-manager -m chacha20-ietf -u --manager-address 127.0.0.1:4000 

Run php api controller  
> $ screen -S api   
> $ php api.php   

Set up crontab  
> $ crontab -e    

```
* * * * * /usr/bin/php /root/rcon.php >> /root/rcon.log  
* * * * * sleep 10; /usr/bin/php /root/rcon.php >> /root/rcon.log  
* * * * * sleep 20; /usr/bin/php /root/rcon.php >> /root/rcon.log  
* * * * * sleep 30; /usr/bin/php /root/rcon.php >> /root/rcon.log  
* * * * * sleep 40; /usr/bin/php /root/rcon.php >> /root/rcon.log  
* * * * * sleep 50; /usr/bin/php /root/rcon.php >> /root/rcon.log  
```
