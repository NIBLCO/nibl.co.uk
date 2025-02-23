#!/bin/bash
docker build -f Dockerfile -t niblcouk .
docker stop niblcouk
docker rm niblcouk
docker run -d --net='my-bridge' -v '/opt/nibl.co.uk/var':'/var/www/html/var':'rw' --name=niblcouk niblcouk
