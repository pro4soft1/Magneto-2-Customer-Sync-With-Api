# Magneto 2 Customers Syn with Api
### This Module Is Basic module used to sync your magneto 2 stores customers with any third party api via command line or cron jobs or manually from magneto 2 admin

## Module Requirements  
1.   php -8.1 +
2.  magneto 2.4.5 +

## Module Installation
1.  clone the code or download it to the **app/code/Tecno**
2. run this command  **_s:up_**
2. run this command  **_s:d:c_**
2. change the module configuration located in  **Stores/Configuration/Integration/Customer-Integration**
2. run this command  **_c:f_**

## How the module Works

1. run command  : **bin/magento sync-customers** 
2. mass action form admin 
3. cron job 

  ## How To Test The Module
you can test this module via 3 ways form command line or cron job or via mass Action form magneto 2 admin 
but before all this you have to check the configration first 
and make sure the config api endpoint is set to :
https://649840e49543ce0f49e1ce9c.mockapi.io/magento/customers
to check any action of this module you can find the log file in **/var/log/customers-sync.log**
also via open this url in your browser you will see all your customers there : https://649840e49543ce0f49e1ce9c.mockapi.io/magento/customers 
after you sync your customers
