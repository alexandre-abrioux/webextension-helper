#!/usr/bin/env bash
ROOT=`cd "$(dirname "${BASH_SOURCE[0]}")" && pwd`
cd ${ROOT}
if [ ! -f .env ]; then
    echo 'No config file found. Copy "helper/.env.dist" to "helper/.env" and edit it.'
    exit 1
fi
source .env
web-ext sign