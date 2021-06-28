In App Purchases Subscription Management | PHP API & Cordova 

Mobile subscription management PHP API project with cordova mobile app example

PHP Api
/* Register */
POST
URL: localhost/api/register
Queries: uid,appid,language,operatingsystem
/* Google Api */
POST
URL: localhost/api/googleapi
Queries: q,client-token,receipt
/* Purchase */
POST
URL: localhost/api/purchase
Queries: uid,appid,language,operatingsystem,type,client-token
/* Check Subscription */
POST
URL: localhost/api/checksubscription
Queries: uid,appid,language,operatingsystem,client-token
/* Worker and Cron URL */
GET
URL: localhost/api/worker
/* Report */
GET
URL: localhost/api/report
Queries: minId,maxId,appId

Cordova Android Example
Directory: ./Cordova-Android-Example/
Example APP: ./Cordova-Android-Example/app-debug.apk
