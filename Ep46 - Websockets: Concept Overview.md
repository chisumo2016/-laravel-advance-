### Websockets: Concept Overview
    [X] In the world today , there's an integrated featured with real time featured
    [X]How the real app works
         A PERSON        SERVER MIDDLE           B PERSON 
            Person A will see the status oF B Person (0nline) ,while B person will the Person is typing .
         Person a will send a request to the Server ,update the db   same as B
         Will send the HTTP request pers 5 sec to update the informatio db
         Person B will not be able to see the status if A is typing - This we call POLLING
   
    [X] HTTP is very slow for real time application, depend of location of app server .This delay is bad for reat time app.
    [X] HTTP is very heavy .it contains a header and body , cookies and other meta data .
    [X] In real time app will be having a lot of messages coming in and out .
    [X] Problem with Bandwidth in HTTP request

    [X] What is better solution to create realtime applications contrast to HTTP ?
    [X] The solution is to use Websocket .  
            We need something which is fast and supported by browser.
            Websocket allows the computer to talk each other .Just like http

          Websocket     Client                     Server
            Connection btn client and server a maintained and persisted .
            Send the msg through existing connection, no need to establish the connnection .
            Much faster than http
    [X] Two pattern when building the websocket 
            1: Publisher Subcriber Pattern
                    One Publisher (server) with alot of Subscribers (client)
                    When the server is sending out the msg,all the sub will getting the msg
                     One way of send the msg and cliet receive .
           
                        example:Finance app , bitcoi app
                    Can be used to stream live video data .eg cctv 
            2: Remote Procedure Call (RPC)
               Is the two way communicatiion  protocal 
                    CLIENT                 SERVER
                Client will establish the connection with the server
                 Execute the remote function on the server .
                Client can send informationn to Server via Request
                        Example: Chat Messaginng App .
                Inn the chat apps could be a combination of Pub Sub and RPC working together .
    
        Websocket is a communication protocal to transmit data between computers, where it is commonly used in realtime apps.
        In contrast to HTTP ,WS persists and maintains its connnecction with the server , so the subsequent data 
            transmission will be lighting fast .
        There are 2 commons WS app pattern .
            PubSub
            RPC
        PubSub involves 1 server that broadcasts message to multiple clients . Commonly seee in financial app
          there is a need to stream realtime price data.
        RPC is very similar too HTTP, where the client will send a request annd expect a reply from the server.
            RPC can be used in messaging apps.
