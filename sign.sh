#!/usr/bin/env bash
ROOT=`cd "$(dirname "${BASH_SOURCE[0]}")" && pwd`
cd ${ROOT}
source .env
web-ext sign --api-key=${API_USER} --api-secret=${API_KEY}