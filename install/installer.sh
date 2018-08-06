#!/bin/bash

echo "Installing Microweber cPanel plugin...";

## Check if being ran by root
username=`whoami`
if [ "$username" != "root" ]; then
    echo "Please run this script as root";
    exit 1
fi

chmod_files=`chmod +x -R /usr/local/cpanel/microweber`

if [ -z "$chmod_files" ]; then
    echo "Unable to CHMOD the cPanel plugin"
fi

register_cp=`/usr/local/cpanel/scripts/install_plugin /usr/local/cpanel/microweber/install/mw-plugin`

if [ -z "$register_cp" ]; then
    echo "Unable to register cPanel plugin"
    exit 1
fi

register_whm=`/usr/local/cpanel/bin/register_appconfig /usr/local/cpanel/microweber/install/microweber.conf`

if [ -z "$register_whm" ]; then
    echo "Unable to register WHM plugin"
    exit 1
fi

register_hooks=`/usr/local/cpanel/bin/manage_hooks add script /usr/local/cpanel/microweber/hooks/mw_hooks.php`

if [ -z "$register_hooks" ]; then
    echo "Unable to register hooks"
    exit 1
fi

## Create symlinks
echo "Creating symlinks...";

step1=`mkdir /usr/local/cpanel/whostmgr/docroot/cgi/3rdparty/microweber`

if [ -z "$step1" ]; then
    echo "Unable to complete step 1"
    exit 1
fi

step2=`ln -s /usr/local/cpanel/microweber/whm/index.cgi /usr/local/cpanel/whostmgr/docroot/cgi/3rdparty/microweber/index.cgi`

if [ -z "$step2" ]; then
    echo "Unable to complete step 2"
    exit 1
fi

step3=`mkdir /usr/local/cpanel/whostmgr/docroot/3rdparty/microweber`

if [ -z "$step3" ]; then
    echo "Unable to complete step 3"
    exit 1
fi

step4=`ln -s /usr/local/cpanel/microweber/whm/admin.php /usr/local/cpanel/whostmgr/docroot/3rdparty/microweber/admin.php`

if [ -z "$step4" ]; then
    echo "Unable to complete step 4"
    exit 1
fi

step5=`ln -s /usr/local/cpanel/microweber/install/mw-plugin/microweber.png /usr/local/cpanel/whostmgr/docroot/addon_plugins/microweber.png`

if [ -z "$step5" ]; then
    echo "Unable to complete step 5"
    exit 1
fi

step6=`ln -s /usr/local/cpanel/microweber/hooks /var/cpanel/microweber`

if [ -z "$step6" ]; then
    echo "Unable to complete step 6"
    exit 1
fi
