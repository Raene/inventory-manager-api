###################
Backend Api for Inventory manager
###################

*******************
Requirements
*******************

Php, Mysql and Apache server are needed to run this api.

**************************
Creating a User
**************************

This backend api uses one endpoint for both  user and admin login.
By default any user registering on the Inventory manager is an Admin of his/her/non-binary/trans inventory.
Admins can create users(to help manage their inventory with limited access).

When registering an admin-user the expected payload is 
{
    user: {
        name,
        email,
        password
    }    
}
All users are on the user table, admin users are identified by the value "admin" under the role column. 

**************************
Available Routes Include
**************************
['localhost/inventory-manager-api/user']['POST']   
['localhost/inventory-manager-api/user/(:any)']['GET']               
['localhost/inventory-manager-api/user']['GET']                      
['localhost/inventory-manager-api/auth/login']['POST']               
['localhost/inventory-manager-api/auth/register']['POST']            
['localhost/inventory-manager-api/products/(:any)']['GET']           
['localhost/inventory-manager-api/products/(:any)']['DELETE']        
['localhost/inventory-manager-api/products']['PUT']                  
['localhost/inventory-manager-api/products']['POST']                 
['localhost/inventory-manager-api/products']['GET']                  
['localhost/inventory-manager-api/expenses/month']['GET']            
['localhost/inventory-manager-api/expenses/today']['GET']            
['localhost/inventory-manager-api/expenses/week']['GET']             
['localhost/inventory-manager-api/expenses/(:any)']['DELETE']        
['localhost/inventory-manager-api/expenses']['POST']                 
['localhost/inventory-manager-api/expenses']['GET']                  
['localhost/inventory-manager-api/sales/sum']['GET']                 
['localhost/inventory-manager-api/sales/sum']['GET']                 
['localhost/inventory-manager-api/sales/today']['GET']               
['localhost/inventory-manager-api/sales/week']['GET']                
['localhost/inventory-manager-api/sales/month']['GET']               
['localhost/inventory-manager-api/sales/month']['GET']               
['localhost/inventory-manager-api/sales']['GET']                     


