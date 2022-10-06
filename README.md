# Magento2 Module for Flashy

## Features
Flashy's extension adds tracking events (add to cart, purchase). It also allows you to sync products and order statuses.

## Installation

### Step 1 - Install the module via composer 

```
composer require flashy/module-integration
```


### Step 2 -  Enable the module
```
bin/magento module:enable --clear-static-content Flashy_Integration
bin/magento setup:upgrade
bin/magento cache:flush
```

### Step 3 - Configuration

#### Get Flashy API Key 
1. Login to Flashy Dashboard 
2. Click on account avatar located on the top-right corner (top-left if your language is Hebrew) 
3. On the menu click on API 
4. Copy the API key

#### Enable the Magneot module  
1. Login to Magento Admin 
2. From the admin menu go to Flashy -> Flashy Settings 
3. Set __Enable__ to Yes 
4. Set __Send purchase before payment__ to Yes
4. Paste the API key you copied from Flashy Dashboard to __API Key__
5. Save the configuration 
6. Clear Magento caches. 




