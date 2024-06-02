#!/bin/bash

cd /app

if [ "$NODE_INSTALL" != "false" ]
then
    echo "installing node_modules"
    npm install
fi

echo "starting app"
npm run serve

exit 0
