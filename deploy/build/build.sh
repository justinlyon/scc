#!/bin/bash

SQLUser=sccuser
SQLPassword=j@ck2olo
SQLDB=scc

BUILD=`pwd`
ROOT=$BUILD/../..
DEPLOY=$ROOT/deploy
SRC=$BUILD/../../src

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

# If a user is provided, tack on a user ID to the config files
if [ -n "$user" ]
then
    echo "Copying config files for $user..."
    cp $SRC/configuration.php $SRC/configuration.php.$user
    cp $SRC/gallery2/config.php $SRC/gallery2/config.php.$user
    cp $SRC/administrator/components/com_ccevents/WEB-INF/local.include.php $SRC/administrator/components/com_ccevents/WEB-INF/local.include.php.$user
fi

# Dump the contents of the scc SQL database into a file in the build directory
if [ "$verbose" = "1" ]
then
    mysqldump -v -u$SQLUser -p$SQLPassword $SQLDB > $DEPLOY/$SQLDB.sql
else
    mysqldump -u$SQLUser -p$SQLPassword $SQLDB > $DEPLOY/$SQLDB.sql
fi

# Package the contents of the src directory for deployment
if [ "$verbose" = "1" ]
then
    tar czvf $DEPLOY/build.tgz -C $ROOT $SRC $DEPLOY/$SQLDB.sql
else
    tar czf $DEPLOY/build.tgz -C $ROOT $SRC $DEPLOY/$SQLDB.sql
fi

# Send to deployment server
echo "Build Complete"
echo "Run the following command to transfer the build package to the deployment server:"
echo "scp $DEPLOY/build.tgz tachometry@$SQLDB.kapow.com:/tmp/"
