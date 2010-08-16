#!/bin/sh

SQLUser=autry
SQLPassword=n9fr3dr$

BUILD=`pwd`
ROOT=$BUILD/../..
DEPLOY=$ROOT/deploy
SRC=$ROOT/src

function usage
{
    echo "usage: $0 [-v] [-h] [-u user]"
}

while [ "$1" != "" ]; do
    case $1 in
        -v | --verbose )        verbose=1
                                ;;
        -u | --user )           shift
                                user=$1
                                ;;
        -h | --help )           usage
                                exit
                                ;;
        * )                     usage
                                exit 1
    esac
    shift
done

# If a user is provided, copy old config files to /tmp for safe keeping 
if [ -n "$user" ]
then
    cp $SRC/configuration.php /tmp/configuration.php.$user
    cp $SRC/gallery2/config.php /tmp/config.php.$user
fi

# Back up old SQL database
if [ "$verbose" = "1" ]
then
    mysqldump -v -u$SQLUser -p$SQLPassword autry > /tmp/autryBackup.sql
else
    mysqldump -u$SQLUser -p$SQLPassword autry > /tmp/autryBackup.sql
fi

# Tar/Zip old src
if [ "$verbose" = "1" ]
then
    tar czvf $DEPLOY/src.old.tgz -C $ROOT $SRC
else
    tar czf $DEPLOY/src.old.tgz -C $ROOT $SRC
fi

# Remove old webroot
mv $SRC $SRC.old

# Deploy latest build 
if [ "$verbose" = "1" ]
then
    tar xzvf /tmp/build.tgz -C $ROOT 
else
    tar xzf /tmp/build.tgz -C $ROOT 
fi

# Drop old SQL database
if [ "$verbose" = "1" ]
then
    mysqladmin -v drop autry
else
    mysqladmin drop autry
fi

# Creat new SQL database
if [ "$verbose" = "1" ]
then
    mysqladmin -v create autry
else
    mysqladmin create autry
fi

# Import new SQL database
if [ "$verbose" = "1" ]
then
    mysql -v -u$SQLUser -p$SQLPassword autry < $DEPLOY/autry.sql
else
    mysql -u$SQLUser -p$SQLPassword autry < $DEPLOY/autry.sql
fi

# If a user is provided, copy user config files into place
if [ -n "$user" ]
then
    if [ -e "$SRC/configuration.php.$user" ]
    then
        cp $SRC/configuration.php.$user $SRC/configuration.php
    fi
    if [ -e "$SRC/gallery2/config.php.$user" ]
    then
        cp gallery2/config.php.$user gallery2/config.php
    fi
    if [ -e "$SRC/administration/components/com_ccevents/WEB-INF/local/include.php.$user" ]
    then
        cp $SRC/adminstration/components/com_ccevents/WEB-INF/local.include.php.$user $SRC/adminstration/components/com_ccevents/WEB-INF/local.include.php
    fi
fi

# Clean Up
rm -rf $SRC.old
